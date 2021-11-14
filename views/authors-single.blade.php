@extends('base')

@section('content')

    <h5>{{$author['first_name']}} {{$author['last_name']}}</h5>

    <table class="table">
        <thead>
            <tr>
            <th scope="col">Birthday</th>
            <th scope="col">Gender</th>
            <th scope="col">Place of birth</th>
            <th scope="col">Gender</th>

            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>{{date($_ENV['DEFAULT_DATE_FORMAT'], strtotime(($author['birthday'])))}}</td>
                    <td>{{$author['gender']}}</td>
                    <td>{{$author['place_of_birth']}}</td>
                    <td>{{$author['gender']}}</td>
                </tr>
    
        </tbody>
        </table>

        <h5>Biography</h5>
        <p>{{$author['biography']}}</p>
        <br>

        <h4>Books:</h5>

            <table class="table">
        <thead>
            <tr>
            <th scope="col">Id</th>
            <th scope="col">Title</th>
            <th scope="col">Format</th>
            <th scope="col">Isbn</th>
            <th scope="col">Release date</th>
            <th scope="col">Number of pages</th>
            <th scope="col"></th>

            </tr>
        </thead>
        <tbody>
            @foreach($author['books'] as $book)
                <tr>
                    <td>{{$book['id']}}</th>
                    <td>{{$book['title']}}</td>
                    <td>{{$book['format']}}</td>
                    <td>{{$book['isbn']}}</td>
                    <td>{{date($_ENV['DEFAULT_DATE_FORMAT'], strtotime(($book['release_date'])))}}</td>
                    <td>{{$book['number_of_pages']}}</td>
                    <td><form method="POST" action="<?php echo ($_ENV['BASE_URL'] . '/books/'. $book['id']) ?>">
                            <input type="hidden" name="method" value="DELETE"/>

                        <input type="hidden" name="author_id" value="{{$author['id']}}"/>
                        <input type="submit" class="text-danger"  value="Delete" ?>
                        </form>
                    </td>
                
                </tr>
            @endforeach
            
        </tbody>
    </table>

@endsection