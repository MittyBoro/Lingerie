<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class MediaController extends Controller
{

    /**
     * пока не требуется
     */

    public function store(Request $request, Media $media)
    {
        $model = $this->checkModel($request);
        $validated = $request->validate([
            'upload' => 'dimensions:min_width=10,min_height=10|max:10000',
        ]);

        $media = $model->syncMedia(['file' => $validated['upload']]);

        return ['urls' => ['default' => $media->getFullUrl()] ];
    }

    public function destroy($id)
    {
        $media = Media::find($id);

        if (!$media)
            return back()->withErrors(['Файл не найден']);

        $model_type = $media->model_type;

        $model = $model_type::find($media->model_id);
        $model->deleteMedia($media->id);
        $media->delete();

        return back();
    }

    private function checkModel($request)
    {
        $modelName = Str::studly($request->type);
        $id = $request->id;

        $modelClass = 'App\\Models\\'.$modelName;

        if ( !class_exists($modelClass) ||
                !($model = $modelClass::find($id)) ) {

            throw ValidationException::withMessages(['type_id' => 'Неверное имя поля']);
        }
        return $model;
    }
}
