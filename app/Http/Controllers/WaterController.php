<?php

namespace App\Http\Controllers;

use App\Repositories\WaterRepository;
use Illuminate\Http\Request;

class WaterController extends Controller
{    
    /**
     * Recebe o arquivo com as entradas para processamento
     *
     * @param  Request $request
     * @return response
     */
    public function receiveFile(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json([
                'msg' => 'É necessário anexar o arquivo.'
            ], 403);
        }

        $n_lines = count(file($request->file('file')));
        $lengths = [];
        $arrays = [];

        foreach (file($request->file('file')) as $line => $content) {
            if ($line === 0) {
                $n_cases = intval($content);
                $n_lines_cases = ($n_cases * 2) + 1;

                if ($n_lines_cases !== $n_lines) {
                    return response()->json([
                        'msg' => 'O arquivo contém a quantidade de casos diferente da informada'
                    ], 403);
                }
            } else {
                if ($line % 2 === 0) {
                    $arrays[] = $content;
                } else {
                    $lengths[] = intval($content);
                }
            }
        }

        $results = [];
        for ($i = 0; $i < count($lengths); $i++) {
            $water_repository = new WaterRepository();
            
            $new_array = array_map('intval', explode(' ', $arrays[$i]));
            
            $results[] = $water_repository->sumWaterAccumulation($new_array, $lengths[$i]);
        }

        return response()->json([
            'resultados' => $results
        ], 200);
    }
}
