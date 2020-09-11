<h1>Edit auto</h1>
{{-- Validazione form --}}
@if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

{{-- Add new car form --}}
<form action="{{route('cars.update', $car)}}" method="post">
  @csrf
  @method('PUT')
  <label>Manifacturer:</label><br>
  <input type="text" name="manifacturer" value="{{ isset($car->manifacturer)? $car->manifacturer : old('manifacturer') }}" placeholder="manifacturer">
  <br>
  <br>
  <label>Year:</label><br>
  <input type="number" name="year" value="{{ isset($car->year)? $car->year : old('year')}}" placeholder="year">
  <br>
  <br>
  <label>Engine:</label><br>
  <input type="text" name="engine" value="{{ isset($car->engine)? $car->engine : old('engine')}}" placeholder="engine">
  <br>
  <br>
  <label>Plate:</label><br>
  <input type="text" name="plate" value="{{ isset($car->plate)? $car->plate : old('plate')}}" placeholder="plate">
  <br>
  <br>
  <div class="chekboxes">
    <span>Type:</span>
    @foreach ($tags as $tag)
      <div>
        <input type="checkbox" name="tags[]" value="{{$tag->id}}" {{ ($car->tags->contains($tag)) ? 'checked' : '' }}>
        <label>{{$tag->name}}</label>
      </div>
    @endforeach
  </div>
  <br>
  <br>
  <div>
    <select name="user_id">
      @foreach ($users as $user)
        <option value="{{$user->id}}">{{$user->name}}</option>
      @endforeach
    </select>
  </div>
  <br>
  <br>
  <input type="submit" name="" value="save">
</form>
