<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ItunesApiRequestTrait;
use Inertia\Inertia;
use App\Models\Track;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class ItunesApiRequestController extends Controller
{
  use ItunesApiRequestTrait;

  public function requestApi(Request $request)
  {
    // CHECK IF THE VARIABLE WAS LOADED // VERIFICA SI SE CARGO LA VARIABLE

    if ($request->get('name') == '') {
      $data['message'] = 'Debe ingresar un nombre de Artista o Banda';
      return response()->json($data, 200);
    }

    // CHECK IF THERE IS A SEARCH CACHE // VERIFICACION SI EXISTE EL CACHE DE LA BUSQUEDA ANTERIOR

    if (Cache::get('cache_artistSearch') == $request->get('name')) {

      // IF IT EXISTS, RETURNS THE CACHED DATA // SI EXISTE RETORNA LOS DATOS CACHEADOS  

      $data['track']                = Cache::get('track');
      $data['total_albums']         = Cache::get('total_albums');
      $data['total_track']          = Cache::get('total_track');
      $data['albums']               = Cache::get('albums');
      $data['cache_artistSearch']   = Cache::get('cache_artistSearch');

      return response()->json($data, 200);
    } else {
      //IF IT DOES NOT MAKE THE CALL TO THE ITUNES API AGAIN // SINO VUELVE A REALIZAR LA LLAMADA A LA API DE ITUNES 

      $response = $this->RequestItunesApi($request->get('name'));

      for ($i = 0; $i < count($response['results']); $i++) {
        $short  = $response['results'][$i];
        $date   = Carbon::parse($short['releaseDate'])->format('d/m/Y');
        if ($short['artistName'] == $request->get('name')) {
          $data['track'][$i] = array(
            'artistName'    => $short['artistName'],
            'trackId'       => $short['trackId'],
            'collectionId'  => $short['collectionId'],
            'trackName'     => $short['trackName'],
            'previewUrl'    => $short['previewUrl'],
            'releaseDate'   => $date,
            'image'         => $short['artworkUrl60'],
            'collectionName' => $short['collectionName'],
            'price'         => array(
              'amount' => $short['trackPrice'],
              'currency' => $short['currency']
            )
          );

          $collection[$i] = $short['collectionName'];
          $track[$i]      = $short['trackName'];
        }
      }

      if (!isset($collection)) {
        $data['message'] = 'No existe Artista con el nombre';
        return response()->json($data, 200);
      }

      //EXTRACTING UNIQUE DATA FROM ALBUMS // EXTRAYENDO DATOS UNICOS DE ALBUMES

      $collection_unique  = array_unique($collection);

      //EXTRACTING UNIQUE MUSIC DATA // EXTRAYENDO DATOS UNICOS DE MUSICAS

      $track_unique       = array_unique($track);

      // COUNTING NUMBER OF ALBUMS AND MUSIC PRESENT // CONTANDO CANTIDAD DE ALBUMES Y MUSICAS PRESENTES
      $data['total_albums'] = count($collection_unique);
      $data['total_track'] = count($track_unique);

      //LOADING ALBUM DATA AND SEARCH CARRIED OUT // CARGANDO DATOS DE ALBUMES Y BUSQUEDA REALIZADA
      $data['albums'] = $collection_unique;
      $data['cache_artistSearch']  = $request->get('name');

      //CACHE PUT // PUT DE CACHE
      Cache::put('data', $data, 3600);

      return response()->json($data, 200);
    }
  }

  public function fav(Request $request)
  {

    $data['artistName'] = $request->get('artistName');
    $data['trackId']    = $request->get('trackId');
    $data['user']       = $request->get('user');
    $data['trackName']  = $request->get('trackName');
    $data['ranking']    = '5/5';

    return response()->json($data, 200);
  }
}
