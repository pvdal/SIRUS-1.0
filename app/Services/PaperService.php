<?php

namespace App\Services;

use App\Models\Group;
use Illuminate\Http\UploadedFile;
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
        // Monta caminho de diretórios
        $path = 'papers/' . implode('/', $folders);
        Storage::disk('public')->makeDirectory($path);

        // Nome original + hash SHA256 de 30 chars
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $hash = substr(hash('sha256', $originalName . time()), 0, 30);

        $newFileName = $originalName . '_' . $hash . '.' . $extension;
        // Salva o arquivo
        $filePath = $file->storeAs($path, $newFileName, 'public');

        // Cria registro no banco
        return Paper::create([
            'title' => $originalName,
            'file_path' => $filePath,
            'group_id' => $groupId,
        ]);
    }

    /**
     * Atualiza o paper de um grupo: se o arquivo for igual, só atualiza o título;
     * se diferente, apaga os antigos e cria novo.
     */
    public function updatePaper(UploadedFile $file, Group $group, array $folders): Paper
    {
        $oldPaper = $group->papers()->latest()->first();
        // Hash real do novo arquivo (SHA1 do conteúdo)
        $newHash = sha1_file($file->getRealPath());

        if($oldPaper) {
            // Lê o arquivo atual no storage e calcula hash
            $oldHash = sha1(Storage::disk('public')->path($oldPaper->file_path));

            if ($newHash === $oldHash) {
                // Mesmo arquivo → só atualiza título se mudou
                $oldPaper->fill([
                    'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                ]);

                if($oldPaper->isDirty()) {
                    $oldPaper->save();
                    $group->touch();
                }

                return $oldPaper; // não mexe no banco nem cria arquivo novo
            }
        }

        // Novo arquivo -> mantém os antigos, só cria outro
        return $this->createPaper($file, $group->id, $folders);
    }
}
