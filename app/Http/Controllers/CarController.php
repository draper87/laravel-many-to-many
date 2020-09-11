<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;
use App\Tag;
use App\User;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $cars = Car::all();

      return view('cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        $users = User::all();

        return view('cars.create', compact('tags', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validazione
        $request->validate($this->validationData());

        $requested_data = $request->all();
        // dd($requested_data);

        // Nuova istanza Car
        $new_car = new Car();
        $new_car->manifacturer = $requested_data['manifacturer'];
        $new_car->year = $requested_data['year'];
        $new_car->engine = $requested_data['engine'];
        $new_car->plate = $requested_data['plate'];
        $new_car->user_id = $requested_data['user_id'];
        $new_car->save();

        if (isset($requested_data['tags'])) {
          $new_car->tags()->sync($requested_data['tags']);
        }

        return redirect()->route('cars.show', $new_car);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
      // dd($car->tags);
      return view('cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        $tags = Tag::all();
        $users = User::all();
        return view('cars.edit', [
          'car' => $car,
          'tags' => $tags,
          'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
      // Validazione
      $request->validate($this->validationData());

      $requested_data = $request->all();


      $car->update($requested_data);

      if(isset($requested_data['tags'])) {
        $car->tags()->sync($requested_data['tags']);
      }

      // ritorno alla pagina principale se la modifica e avvenuta con successo
      if ($car) {
        $cars = Car::all();
        return view('cars.index', compact('cars'));
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {

        $car->tags()->detach();

        $car->delete();

        if ($car) {
          return redirect()->route('cars.index');
        }
    }

    public function validationData() {
      return [
        'manifacturer' => 'required|max:255',
        'year' => 'required|integer|min:1990|max:2020',
        'engine' => 'required|max:255',
        'plate' => 'required|max:255',
        'user_id' => 'required|integer',
      ];
    }
}
