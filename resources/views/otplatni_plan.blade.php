@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 bg-white">
                <div class="col mt-3 pb-3">
                    <h2 class="title">Otplatni plan ugovora br. x x x x</h2>
                </div>
                <h1>DUGOVANJA: {{$sumaDugovanja}}</h1>
                <h2>losi ugovori {{json_encode($losUgovor)}}</h2>
                <table id="ugovori" class="table table-striped table-bordered no-wrap" style="border-collapse: collapse;">
                    <thead>
                    <tr>
                        <th>Plaćanje</th>
                        <th>Kamata</th>
                        <th>Otplata</th>
                        <th>Ostatak duga</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    <tr class="bg-white">
                        <td>0</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
    </script>
@endpush
