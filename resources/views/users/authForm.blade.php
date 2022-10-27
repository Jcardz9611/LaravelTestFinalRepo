@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User Authorization:') }} {{$user->name}}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.saveAuth', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="authorized" class="col-md-4 col-form-label text-md-end">{{ __('Authorization') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="authorized">
                                    <option value="0"{{ $user->authorized == 0 ? 'selected' : ''}}>Unauthorized</option>
                                    <option value="1"{{ $user->authorized == 1 ? 'selected' : '' }}>Authorized</option>
                                </select>
                            </div>
                        </div>
                        </div>
                

                    

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection