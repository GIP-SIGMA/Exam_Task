<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Modern Todo App</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }
        
        .table {
            color: #495057;
        }
        
        .table thead th {
            border-bottom: 2px solid #e9ecef;
            color: #6c757d;
            font-weight: 600;
            background-color: #f8f9fa;
        }
        
        .btn-primary {
            background-color: #4361ee;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
        }
        
        .btn-primary:hover {
            background-color: #3046eb;
        }
        
        .btn-info {
            background-color: #4cc9f0;
            border: none;
            color: white;
        }
        
        .btn-danger {
            background-color: #f72585;
            border: none;
        }
        
        .badge {
            padding: 8px 12px;
            border-radius: 6px;
        }
        
        .bg-warning {
            background-color: #ffd60a !important;
            color: #000;
        }
        
        .bg-success {
            background-color: #2ec4b6 !important;
        }
        
        .form-control {
            border-radius: 8px;
            border: 1px solid #e9ecef;
            padding: 10px 15px;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
            border-color: #4361ee;
        }
        
        .search-icon {
            color: #4361ee;
        }
        
        .search-form {
            background-color: white;
            padding: 10px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <!-- Search icon and form -->
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-end">
                <div class="position-relative">
                    <button class="btn btn-link search-icon" type="button" onclick="toggleSearch()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                    </button>
                    <form action="{{ route('todos.index') }}" method="GET" id="searchForm" class="position-absolute end-0 search-form" style="display: none; width: 300px; z-index: 1000;">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search by title..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-lg-6">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{$error}}
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="text-center mt-4">
        <h2 class="mb-4" style="color: #2b2d42;">Add Task</h2>
        <form class="row g-3 justify-content-center" method="POST" action="{{route('todos.store')}}">
            @csrf
            <div class="col-6">
                <input type="text" class="form-control mb-3" name="title" placeholder="Title">
                <textarea class="form-control mb-3" ></textarea>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Add Task</button>
            </div>
        </form>
    </div>

    <div class="text-center mt-5">
        <h2 class="mb-4" style="color: #2b2d42;">All Tasks</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <th>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </th>
                            <tbody>
                                @php $counter=1 @endphp
                                @foreach($todos as $todo)
                                    <tr>
                                        <th>{{$counter}}</th>
                                        <td>{{$todo->title}}</td>
                                        <td>{{$todo->description}}</td>
                                        <td>
                                            @if($todo->is_completed)
                                                <div class="badge bg-success">Completed</div>
                                            @else
                                                <div class="badge bg-warning">Pending</div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('todos.edit',['todo'=>$todo->id])}}" class="btn btn-info btn-sm">Edit</a>
                                            <a href="{{route('todos.destory',['todo'=>$todo->id])}}" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                    @php $counter++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $todos->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSearch() {
            const searchForm = document.getElementById('searchForm');
            if (searchForm.style.display === 'none') {
                searchForm.style.display = 'block';
                searchForm.querySelector('input').focus();
            } else {
                searchForm.style.display = 'none';
            }
        }

        document.addEventListener('click', function(event) {
            const searchForm = document.getElementById('searchForm');
            const searchButton = event.target.closest('button');
            const form = event.target.closest('form');
            
            if (!searchButton && !form) {
                searchForm.style.display = 'none';
            }
        });
    </script>
</body>
</html>