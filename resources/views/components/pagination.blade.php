@props(['id' => 'dataTable'])

<div class="pagination" id="pagination{{ $id }}">
    <ul>
        <li><a href="##prev" id="prev{{ $id }}">&laquo;</a></li>
        <li class="page-links"></li>
        <li><a href="##next" id="next{{ $id }}">&raquo;</a></li>
    </ul>
</div>
