<?php

namespace App\Traits;

 use Illuminate\Support\Collection;
 use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser
{
	private function successResponse($data, $code)
	{
		return response()->json($data, $code);
	}

	protected function errorResponse($message, $code)
	{
		return response()->json(['error' => $message, 'code' => $code], $code);
	}

	protected function showAll(Collection $collection, $code = 200)
	{
		
		return $this->successResponse(['data' => $collection], $code);
	}

	protected function showOne(Model $instance, $code = 200)
	{
		// $transformer = $instance->transformer;
		// $instance = $this->transformData($instance, $transformer);

		return $this->successResponse(['data' => $instance], $code);
	}

	
}