<x-app-layout>
  <div class="row mt-3">
    @can('crear-formularios')
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('form.siniestros') }}">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Form Siniestros</h4>
                    </div>
                   {{--  <div class="card-body">
                        10
                    </div> --}}
                </div>
            </div>
        </a>
    </div>
    @endcan
    @can('editar-form-productos')
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('form.precio') }}">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="far fa-newspaper"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Cambio de Precios</h4>
                    </div>
                    {{-- <div class="card-body">
                        42
                    </div> --}}
                </div>
            </div>
        </a>
    </div>
    @endcan
        {{-- <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fas fa-circle"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Reportes</h4>
              </div>
              <div class="card-body">
                1,201
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="far fa-user"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Usuarios</h4>
              </div>
              <div class="card-body">
                47
              </div>
            </div>
          </div>
        </div>    --}}               
      </div>
</x-app-layout>
