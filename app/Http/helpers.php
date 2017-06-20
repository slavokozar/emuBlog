<?php

/**
 * Returns array ids for given model class of given size. If size is not given,
 * it's set to max for given model.
 * @param $model model class
 * @param null $max max number of returned ids
 * @return array of ids
 */
function get_random_ids_for_model($model, $max = null)
{
    if (is_null($model)) {
        return [];
    }

    if (is_subclass_of($model, '\Illuminate\Database\Eloquent\Model')) {
        if (is_null($max)) {
            $max = rand(1, $model::count());
        }
        return $model::all()->shuffle()->slice(0, $max)->pluck('id')->all();
    }

    return [];
}

function resort_path($resort = null, $path = '')
{
    if (is_null($resort)) {
        return public_path('resorts_media/' . $path);
    }

    return public_path('resorts_media/' . $resort->id . '/' . $path);
}

function resort_image_path($resort, $path = '')
{
    return resort_path($resort, 'images/' . $path);
}

function unassigned_path($path = '')
{
    return public_path('unassigned/' . $path);
}

function asset_resort_image_path($resort, $path = '')
{
    return asset('resorts_media/'.$resort->id.'/images/' . $path);
}

function asset_unassigned_path($path = '')
{
    return asset('unassigned/' . $path);
}

/**
 * @param string $class
 *
 * @return string
 */
function removeNamespace($class)
{
    $class = str_replace('App\Http\Controllers\\', '', $class);

    return $class;
}

/**
 * @param \App\Http\Controllers\Controller $controller
 * @param string $method
 *
 * @return \Illuminate\Contracts\Translation\Translator|string
 */
function getSuccessFlash($controller, $method)
{
    $controller = removeNamespace(get_class($controller));

    return trans('flashes.' . $controller . '.' . $method . '.success');
}

/**
 * @param \App\Http\Controllers\Controller $controller
 * @param string $method
 *
 * @param string|array $message
 *
 * @return \Illuminate\Contracts\Translation\Translator|string
 */
function getInvalidFlash($controller, $method, $message)
{
    $finalMessage = '';
    if (is_array($message)) {
        foreach ($message as $line) {
            $finalMessage .= $line . '<br>';
        }
    } else {
        $finalMessage = $message;
    }

    if ($controller != null && $method != null) {
        $controller = removeNamespace(get_class($controller));

        return trans('flashes.' . $controller . '.' . $method . '.invalid', ['message' => $finalMessage]);
    } else {
        return trans('flashes.global.invalid', ['message' => $finalMessage]);
    }
}

/**
 * @param \App\Http\Controllers\Controller $controller
 * @param string $method
 * @param string|array $message
 *
 * @return \Illuminate\Contracts\Translation\Translator|string
 */
function getErrorFlash($controller, $method, $message)
{
    $controller = removeNamespace(get_class($controller));

    $finalMessage = '';
    if (is_array($message)) {
        foreach ($message as $line) {
            $finalMessage .= $line . '<br>';
        }
    } else {
        $finalMessage = $message;
    }

    return trans('flashes.' . $controller . '.' . $method . '.error', ['message' => $finalMessage]);
}

/**
 * @param \Illuminate\Http\Request $request
 * @param \App\Http\Controllers\Controller $controller
 * @param                                  $method
 * @param array|string $response
 * @param null|string $successText
 *
 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
 */
function success($request, $controller, $method, $response = null, $successText = null)
{
    if ($request->ajax()) {
        if (is_array($response)) {
            $response['flash']['status'] = 'success';
            $response['flash']['info'] = $successText != null ? $successText : getSuccessFlash($controller, $method);
        } elseif ($response != null) {
            $tempResponse = $response;
            $response = [];
            $response['content'] = $tempResponse;
            $response['flash']['status'] = 'success';
            $response['flash']['info'] = $successText != null ? $successText : getSuccessFlash($controller, $method);
        } else {
            $response = [];
            $response['flash']['status'] = 'success';
            $response['flash']['info'] = $successText != null ? $successText : getSuccessFlash($controller, $method);
        }
    }

    return response($response, 200);
}

/**
 * @param \Illuminate\Http\Request $request
 * @param \App\Http\Controllers\Controller $controller
 * @param                                  $method
 * @param array|string $response
 * @param array|string $message - custom error message
 *
 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
 */
function error($request, $controller, $method, $response = null, $message)
{
    if ($request->ajax()) {
        if (is_array($response)) {
            $response['flash']['status'] = 'error';
            $response['flash']['info'] = getErrorFlash($controller, $method, $message);
        } elseif ($response != null) {
            $tempResponse = $response;
            $response['content'] = $tempResponse;
            $response['flash']['status'] = 'error';
            $response['flash']['info'] = getErrorFlash($controller, $method, $message);
        } else {
            $response['flash']['status'] = 'error';
            $response['flash']['info'] = getErrorFlash($controller, $method, $message);
        }
    }


    return response($response, 500);
}

/**
 * @param \Illuminate\Http\Request $request
 * @param \App\Http\Controllers\Controller $controller
 * @param                                  $method
 * @param array|string $response
 * @param array|string $message - validation message
 *
 * @param array|string $errors
 *
 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
 */
function invalid($request, $controller = null, $method = null, $response = null, $message = null, $errors = null)
{
    if ($request->ajax()) {
        if (is_array($response)) {
            $response['flash']['status'] = 'invalid';
            $response['flash']['info'] = getInvalidFlash($controller, $method, $message);
            $response['errors'] = $errors;
        } elseif ($response != null) {
            $tempResponse = $response;
            $response['content'] = $tempResponse;
            $response['flash']['status'] = 'invalid';
            $response['flash']['info'] = getInvalidFlash($controller, $method, $message);
            $response['errors'] = $errors;
        } else {
            $response['flash']['status'] = 'invalid';
            $response['flash']['info'] = getInvalidFlash($controller, $method, $message);
            $response['errors'] = $errors;
        }
    }

    return response($response, 200);
}