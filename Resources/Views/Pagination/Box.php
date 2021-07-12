<nav>
  <ul class="pagination pagination-dark">
    <a class="page-link" href="{{previous}}">Previous</a>
    {{links}}
    <a class="page-link" href="{{next}}">Next</a>
  </ul>
</nav>

<style>
.page-item, .page-link{
  background-color: #212529;
  color: #fff;
}
.page-item.active .page-link{
  background-color: #fff;
  border-color: #212529;
  color: #212529;
}
.page-item:hover, .page-link:hover{
  background-color: #212529;
  color: #fff;
}

</style>