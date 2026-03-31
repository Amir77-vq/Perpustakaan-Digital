<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl">

  <div class="container-fluid py-1 px-3">

    <nav aria-label="breadcrumb">
      <h6 class="font-weight-bolder mb-0 text-black">
        Perpustakaan Digital
      </h6>
    </nav>

    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 justify-content-end">

      <div class="d-flex align-items-center">

        <span class="text-black me-3">
          {{ ucfirst(Auth::user()->role) }}
        </span>

        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button class="btn btn-sm btn-outline-black mb-0" type="submit">
            Logout
          </button>
        </form>
      </div>
    </div>
  </div>
</nav>
