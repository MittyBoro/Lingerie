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


	public function chunks(Request $request)
	{
		// create the file receiver
		$receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

		if ($receiver->isUploaded() === false) {
			throw new UploadMissingFileException();
		}

		$save = $receiver->receive();

		if ($save->isFinished()) {

			try {
				return $this->saveFile($save->getFile(), $request);
			} catch (ValidationException $validattion) {
				return response($validattion->errors(), 415);
			}

			return response([
				'status' => false
			], 500);
		}

		$handler = $save->handler();

		return [
			'done' => $handler->getPercentageDone(),
			'status' => true
		];
	}

	protected function saveFile(UploadedFile $file, Request $request) : Collection
	{
		$validationFile = Validator::make([
			'file' => $file,
		], [
			'file' => [
				'mimetypes:video/webm,video/mpeg,video/mp4,video/quicktime,video/x-matroska',
				'max:' .(1024*2500),
				'min_duration:5'
			],
		])->validated();

		$validationField = Validator::make([
			'field_name' => $request->field_name,
		], [
			'field_name' => 'string',
		])->validated();

		$model = $this->checkModel($request);

		$model->update([
			$validationField['field_name'] => [$validationFile]
		]);

		return $model->{$validationField['field_name']};
	}
}
