@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session()->get('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php
      if (is_array(session()->get('error'))) {
        foreach (session()->get('error') as $key => $err) {
          echo $key.' ';
          if (is_array($err)) {
            foreach ($err as $key1 => $value) {
              echo $key1;
            }
          }else{
            echo $err;
          }
          echo "<br>";
        }
      }else{
        echo session()->get('error');
      }
    ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif







@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    @foreach ($errors->all() as $error)
       <p> {{ $error }} </p>
    @endforeach
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

