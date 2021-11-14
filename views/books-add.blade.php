@extends('base')

@section('content')

<h3 class="mb-4 font-weight-bold">Log in</h3>
<form method="POST" action="<?php echo ($_ENV['BASE_URL'] . '/books') ?>">
  <div class="form-group">
    <label for="exampleInputEmail1">Title</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="title" placeholder="Enter title" value="{{$oldData['title'] ?? null}}">
    @error('title')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Description</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" name="description" rows="3">{{$oldData['description'] ?? null}}</textarea>
    @error('description')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Isbn</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="isbn" placeholder="Enter isbn" value="{{$oldData['isbn'] ?? null}}">
    @error('isbn')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Format</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="format" placeholder="Enter format" value="{{$oldData['format'] ?? null}}">
    @error('format')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Number of pages</label>
    <input type="number" class="form-control" id="exampleInputEmail1" name="number_of_pages" placeholder="Enter number of pages" value="{{$oldData['number_of_pages'] ?? null}}">
    @error('number_of_pages')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Release date</label>
    <input type="date" class="form-control" id="exampleInputEmail1" name="release_date" value="{{$oldData['release_date'] ?? null}}">
    @error('release_date')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Select author</label>
    <select class="form-control" id="exampleFormControlSelect1" name="author">
      <?php foreach ($authors['items'] as $author) {
        $oldAuthorId = isset($oldData['author']) ? $oldData['author'] : null;
        $selected = $oldAuthorId && $oldAuthorId == $author['id'] ? 'selected' : null;
        echo ('<option value="' . $author['id'] . ' "' . $selected . '>' . $author['first_name'] . ' ' . $author['last_name'] . '</option>');
      } ?>

    </select>
  </div>
  <input type="hidden" name="csrf_token" value="{{$csrf}}">
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection