    @extends('base')
    @push('scripts')
    <script type="text/javascript" src="@asset('js/main.js')" defer></script>
    @endpush

    @section('content')
    <style>
       .currentPage {
            background-color: antiquewhite;
       }

    </style>
    @if(isset($_SESSION['flash']) && $_SESSION['flash'] == true)
        <div class="alert alert-success" role="alert">
            Book successfuly added!
        </div>
    @endif
    
    <h1>Artists list</h2>

        <table class="table" id="authorsTable" data-baseUrl="{{$_ENV['BASE_URL']}}">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">First name</th>
                    <th scope="col">Last name</th>
                    <th scope="col">Birthday</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Place of birth</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($authors['items'] as $author)
                <tr>
                    <td>{{$author['id']}}</th>
                    <td>{{$author['first_name']}}</td>
                    <td>{{$author['last_name']}}</td>
                    <td>{{date($_ENV['DEFAULT_DATE_FORMAT'], strtotime(($author['birthday'])))}}</td>
                    <td>{{$author['gender']}}</td>
                    <td>{{$author['place_of_birth']}}</td>
                    <td><a href=<?php echo ($_ENV['BASE_URL'] . '/authors/' . $author['id']) ?>>Details<a></td>
                    <td>
                        <form class="delete-button" data-id="{{$author['id']}}" method="POST" action="<?php echo ($_ENV['BASE_URL'] . '/authors/' . $author['id']) ?>">
                            <input type="hidden" name="method" value="DELETE" />
                            <input type="hidden" name="author_id" value="{{$author['id']}}" />
                            <input type="submit" class="text-danger" value="Delete" ?>
                        </form>
                    </td>

                </tr>
                @endforeach
                <ul class="pagination">
                    <?php

                    paginationLinks($authors);
                    ?>
                </ul>
            </tbody>
        </table>

        <?php
        unset($_SESSION['flash'])
        ?>

        @endsection