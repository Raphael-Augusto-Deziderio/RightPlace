<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Pnlinh\GoogleDistance\Facades\GoogleDistance;
use yidas\googleMaps\Client as GoogleServices;
use Illuminate\Support\Facades\Log;
class HotelSearch extends Controller
{
    public function __construct(Client $client, Request $request)
    {
        $this->client = $client;
        $this->request = $request;
        $this->googleServices = new GoogleServices(['key' => env('GOOGLE_MAPS_API_KEY')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->request->all();
//        $address = $data['address'];
        $address = 'Rua Belém, 249, Santa Marta, Uberaba, Minas Gerais, Brasil';
        $rightPlace = $this->processAddress($address);

        dd($rightPlace);
    }

    public function processAddress($address){
        $result = $this->googleServices->geocode($address);
        $latitude = $result[0]['geometry']['location']['lat'];
        $longitude = $result[0]['geometry']['location']['lng'];

        $rightPlace = $this->getNearbyHotels($latitude, $longitude);
        return $rightPlace;
    }

    public function getNearbyHotels($latitude, $longitude, $orderBy = 'proximity')
    {
        //URL BASE TO ITERATE
        $baseUrl = 'https://xlr8-interview-files.s3.eu-west-2.amazonaws.com/source_';

        //DATA RETURN TYPES
        $returnType = '.json';

        //ITERATION FOR URL BASE
        $iteration = 1;

        //FLAG TO STOP WHILE LOOP
        $stop = 0;

        //CREATING THE HOTEL LIST
        $hotels = [];

        while($stop == 0){
            try{
                $head = $this->client->head($baseUrl.$iteration.$returnType);

                //VALIDATING ROUTE
                if($head->getStatusCode() == 200) {
                    $response = $this->client->request('GET', $baseUrl . $iteration . $returnType);
                    $data = json_decode($response->getBody(), true);
                }
            } catch(\Exception $exception){
                //STOPPING THE WHILE LOOP
                $stop = 1;
            }

                //ITERATE HOTELS
                foreach($data['message'] as $hotel){
                    //GETTING THE COORDENATES
                    $hotelLat = $hotel[1];
                    $hotelLng = $hotel[2];

                    //CALCULATING THE DISTANCE
                    $response = $this->googleServices->distanceMatrix($latitude.",".$longitude, $hotelLat.",".$hotelLng);
                    $result = $response['rows'][0]['elements'][0];

                    if($result['status'] == 'OK'){
                        $distanceValue = $result['distance']['value'];
                        $distanceFormated = $result['distance']['text'];

                        //ADDING IN THE HOTEL LIST
                        $hotels[] = [
                            'name' => $hotel[0],
                            'distanceValue' => $distanceValue,
                            'distanceFormated' => $distanceFormated,
                            'price_per_night' => $hotel[3],
                        ];
                    }
                }
                //INCREMENT ITERATE FOR NEXT ROUTE
                $iteration++;
            }

        //ORDERING BY DISTANCE
        $collectHotels = collect($hotels)->sortBy('distanceValue');

        //GETTING THE NEAREST HOTEL
        
        return $collectHotels->first();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
