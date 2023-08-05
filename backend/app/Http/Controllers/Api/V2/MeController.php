<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use LaravelJsonApi\Core\Document\Error;
use GuzzleHttp\Exception\ClientException;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use App\Models\User;


class MeController extends Controller
{
       /**
     * @param Request $request
     * @return JsonResponse
     */
    public function readProfile(Request $request)
    {
        // return response()->json("teste");

        $http = new Client(['verify' => false]);
        $headers = $this->parseHeaders($request->header());

        $headers = [
            'Accept' => 'application/vnd.api+json',
            'Authorization' => $headers['authorization']
        ];

        $input = $request->json()->all();
        $input['data']['id'] = (string)auth()->id();
        $input['data']['type'] = 'users';

        try {
            $user = User::find($input['data']['id']);
            return response()->json(["data" => $user , "status" => 200, "success"=>true]);
        } catch (ClientException $e) {
            return response()->json(["status" => 201, "success" => false]);

        }
    }

     /**
     * Update the specified resource.
     * Not named update because it conflicts with JsonApiController update method signature
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $http = new Client(['verify' => false]);

        $headers = $this->parseHeaders($request->header());

        $input = $request->json()->all();

        $input['data']['id'] = (string)auth()->id();
        $input['data']['type'] = 'users';

        $data = [
            'headers' => $headers,
            'json' => $input,
            'query' => $request->query()
        ];

        try {
            $response = $http->patch(route('v2.users.update', ['user' => auth()->id()]), $data);
        } catch (ClientException $e) {
            $errors = json_decode($e->getResponse()->getBody()->getContents(), true)['errors'];
            $errors = collect($errors)->map(function ($error) {
                return Error::fromArray($error);
            });
            return ErrorResponse::make($errors);
        }

        $responseBody = json_decode((string)$response->getBody(), true);
        $responseStatus = $response->getStatusCode();
        $responseHeaders = $this->parseHeaders($response->getHeaders());

        unset($responseHeaders['Transfer-Encoding']);

        return response()->json($responseBody, $responseStatus)->withHeaders($responseHeaders);
    }

      /**
     * Parse headers to collapse internal arrays
     * TODO: move to helpers
     *
     * @param array $headers
     * @return array
     */
    protected function parseHeaders($headers)
    {
        return collect($headers)->map(function ($item) {
            return $item[0];
        })->toArray();
    }
}
