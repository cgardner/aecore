<!doctype html>
<html>
    @include('layouts.application.head')
    <body>
        <header class="row">
            <nav class="navbar navbar-fixed-top navbar-default">
                <div class="container-fluid">
                    @include('layouts.application.header')
                </div>
            </nav>
        </header>
        @yield('content')
        <footer class="row"></footer>

        <!-- Initialize Modal -->
        <div class="modal fade" id="modal" data-backdrop="static">
              <div class="modal-dialog">
                  <div class="modal-content">
                  </div> <!-- End Modal Content -->
              </div> <!-- End Modal Dialog -->
        </div> <!-- End Modal -->
        @yield('endbody')
    </body>
</html>