@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm-6 col-lg-4">
                          <div class="card" style="max-width: 18rem;">
                            <div class="card-header bg-behance content-center">
                              <i class="fab fa-behance icon text-white my-4 display-4"></i>
                            </div>
                            <div class="card-body row text-center">
                              <div class="col">
                                <div class="text-value-xl">89k</div>
                                <div class="text-uppercase text-muted small">friends</div>
                              </div>
                              <div class="vr"></div>
                              <div class="col">
                                <div class="text-value-xl">459</div>
                                <div class="text-uppercase text-muted small">feeds</div>
                              </div>
                            </div>
                          </div>
                        </div>
        <br>
        <p class="pt-4">
            My Caseload            
        </p>
    </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection