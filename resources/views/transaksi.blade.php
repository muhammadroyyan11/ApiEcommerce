@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Table Transaksi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Transaksi</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transaksi Pending</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Kode Transaksi</th>
                            <th>Total</th>
                            <th>Bank</th>
                            <th>Alamat Pengiriman</th>
                            <th>Hari Pengiriman</th>
                            <th>Tanggal Pesan</th>
                            <th>Status</th>
                            <th style="width: 140px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listPanding as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->kode_trx }}</td>
                            <td>{{"Rp.".number_format($data->total_transfer)}}</td>
                            <td>{{ $data->bank }}</td>
                            <td>{{ $data->detail_lokasi }}</td>
                            <td>{{ $data->hari }}</td>
                            <td>{{ $data->created_at }}</td>
                            <td>{{ $data->status}}</td>
                            <td>
                                <a href="{{ route('transaksiBatal', $data->id) }}">
                                    <button type="button" class="btn btn btn-danger btn-xs">Batal</button>
                                </a>
                                /
                                <a href="{{ route('transaksiConfirm', $data->id) }}">
                                    <button type="button" class="btn btn btn-success btn-xs">Proses</button>
                                </a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>


        <br>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transaksi Selesai</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="trxDone" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Kode Transaksi</th>
                            <th>Total</th>
                            <th>Bank</th>
                            <th>Alamat Pengiriman</th>
                            <th>Hari Pengiriman</th>
                            <th>Tanggal Pesan</th>
                            <th>Status</th>
                            <th>Bukti TF</th>
                            <th style="width: 140px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listDone as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->kode_trx }}</td>
                            <td>{{"Rp.".number_format($data->total_transfer)}}</td>
                            <td>{{ $data->bank }}</td>
                            <td>{{ $data->detail_lokasi }}</td>
                            <td>{{ $data->hari }}</td>
                            <td>{{ $data->created_at }}</td>
                            <td>{{ $data->status}}</td>
                            <td>
                                <a href="{{ asset('/storage/transfer/'.$data->buktiTransfer) }}" target="_blank" class="btn btn-block btn-primary btn-xs">Download</a>
                            </td>
                            <td>
                                @if($data->status == "DIKIRIM")
                                <a href="{{ route('transaksiSelesai', $data->id) }}">
                                    <button type="button" class="btn btn-block btn-primary btn-xs">Selesai
                                    </button>
                                </a>
                                @elseif($data->status == "PROSES")
                                <a href="{{ route('transaksiKirim', $data->id) }}">
                                    <button type="button" class="btn btn-block btn-success btn-xs">Kirim
                                    </button>
                                </a>
                                @elseif($data->status == "DI BAYAR")
                                <a href="{{ route('transaksiConfirm', $data->id) }}">
                                    <button type="button" class="btn btn-block btn-success btn-xs">Proses
                                    </button>
                                </a>
                                @elseif($data->status == "SELESAI" || $data->status == "BATAL")
                                <a href="#">
                                    <button type="button" class="btn btn-block btn-info btn-xs">Detail
                                    </button>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>

    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection