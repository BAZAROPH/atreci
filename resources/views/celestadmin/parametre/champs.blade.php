<div class="col-lg-4 bg-white">
    <h5 class="m-t-1">Tilde champ</h5>
    <table id="simpletable" class="table dt-responsive nowrap">
        <thead>
            <tr>
                <th>#</th>
                <th>Tilde</th>
                <th>Champ</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Tilde</th>
                <th>Champ</th>
            </tr>
        </tfoot>
        <tbody>
            @php ($i = 0)
            @foreach ($champs as $item)
                @php ($i++)
                <tr>
                    <td>{{ $i }}</td>
                    <td>~{{ $item->libelle }}</td>
                    <td>
                        {{ $item->type_champ->libelle }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
