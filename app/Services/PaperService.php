<?php

namespace App\Services;

use App\Models\Group;
use App\Utils\StringResolve;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Paper;

class PaperService
{
    /**
     * Cria um paper, salvando arquivo e registro no banco.
     *
     * @param UploadedFile $file
     * @param int $groupId
     * @param array $folders ['year', 'semester', 'version', 'course', 'project']
     * @return Paper
     */
    public function createPaper(UploadedFile $file, int $groupId, array $folders): Paper
    {
        $version = $folders['version'] === 'corrected' ? 'corrigido' : 'avaliacao';
        $foldersPath = [
            $folders['year'],
            'semestre_'.$folders['semester'],
            $version,
            StringResolve::normalizeFolderName($folders['course_name']),
            'projeto_integrador_'.$folders['project'],
        ];

        // Monta caminho de diretórios
        $path = 'papers/' . implode('/', $foldersPath);
        Storage::disk('public')->makeDirectory($path);

        // Nome original + hash SHA256 de 30 chars
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $hash = substr(hash('sha256', $originalName . time()), 0, 10);

        $newFileName = $originalName . '_' . $hash . '.' . $extension;
        $filePath = $file->storeAs($path, $newFileName, 'public');// Salva o arquivo

        // Cria registro no banco
        return Paper::create([
            'title' => $originalName,
            'file_path' => $filePath,
            'group_id' => $groupId,
            'year' => $folders['year'],
            'semester' => $folders['semester'],
            'version' => $folders['version'],
            'course_id' => $folders['course_id'],
            'project' => $folders['project'],
        ]);
    }

    /**
     * Atualiza o paper de um grupo: se o arquivo for igual, só atualiza o título;
     * se diferente, cria.
     *
     * @param Paper $paper
     * @param Group $group
     * @param array $folders ['title', 'year', 'semester', 'version', 'course', 'project']
     * @param string $paperTitle
     * @return Paper
     */
    public function updatePaper(Paper $paper,Group $group, array $folders, string $paperTitle): Paper
    {
        $paper->fill([
            'title' => $paperTitle,
        ]);

        if($paper->isDirty()) {
            $paper->save();
            $group->touch();
        }

        $version = $folders['version'] === 'corrected' ? 'corrigido' : 'avaliacao';
        $foldersPath = [
            $folders['year'],
            'semestre_'.$folders['semester'],
            $version,
            StringResolve::normalizeFolderName($folders['course_name']),
            'projeto_integrador_'.$folders['project'],
        ];

        // Pasta nova
        $newDir = 'papers/' . implode('/', $foldersPath);

        $extension = pathinfo($paper->file_path, PATHINFO_EXTENSION);
        $oldFileName = pathinfo($paper->file_path, PATHINFO_FILENAME);

        // Remove o sufixo de hash se existir (underscore + 10 caracteres)
        $oldFileNameWithoutHash = preg_replace('/_[a-f0-9]{10}$/i', '', $oldFileName);

        $oldFileBase = $oldFileNameWithoutHash . '.' . $extension;
        $newFileBase = $paperTitle . '.' . $extension;

        if($newDir !== dirname($paper->file_path) || $newFileBase !== $oldFileBase){
            $hash = substr(hash('sha256', $paperTitle . time()), 0, 10);
            $newFileName = $paperTitle . '_' . $hash . '.' . $extension;
            $newPath = $newDir . '/' . $newFileName;
            // Cria pasta destino caso não exista
            Storage::disk('public')->makeDirectory($newDir);

            // Move fisicamente
            Storage::disk('public')->move($paper->file_path, $newPath);

            // Atualiza no banco
            $paper->update([
                'file_path' => $newPath,
                'group_id'  => $group->id,
                'year'      => $folders['year'],
                'semester'  => $folders['semester'],
                'version'   => $folders['version'],
                'course_id' => $folders['course_id'],
                'project'   => $folders['project'],
            ]);

            $group->touch();
        }

        return $paper;
    }
}
