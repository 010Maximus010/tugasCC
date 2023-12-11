@extends('layouts.main')

@section('content')

<div class="container-scroller">

    @include('layouts.navbar')

    <main>

        <!-- Container START -->
        <div class="container">
            <div class="row g-4">

                @include('layouts.sidebar')

                {{-- Rekap Mahasiswa  --}}
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                              <div class="card-body">
                                <h4 class="card-title" style="text-align: center">Angkatan</h4>
                                <div class="table-responsive pt-3">
                                  <table class="table table-bordered">
                                    <thead class="tahun">
                                        <tr>
                                            <th>
                                                Status
                                            </th>

                                            <th >
                                                <a href="{{ route('data_status', ['angkatan'=>'2017']) }}" class="text-decoration-none">2017</a>
                                            </th>
                                            <th >
                                                <a href="{{ route('data_status', ['angkatan'=>'2018']) }}" class="text-decoration-none">2018</a>
                                            </th>
                                            <th >
                                                <a href="{{ route('data_status', ['angkatan'=>'2019']) }}" class="text-decoration-none">2019</a>
                                            </th>
                                            <th >
                                                <a href="{{ route('data_status', ['angkatan'=>'2020']) }}" class="text-decoration-none">2020</a>
                                            </th>
                                            <th >
                                                <a href="{{ route('data_status', ['angkatan'=>'2021']) }}" class="text-decoration-none">2021</a>
                                            </th>
                                            <th >
                                                <a href="{{ route('data_status', ['angkatan'=>'2022']) }}" class="text-decoration-none">2022</a>
                                            </th>
                                            <th >
                                                <a href="{{ route('data_status', ['angkatan'=>'2023']) }}" class="text-decoration-none">2023</a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="status">
                                        <tr>
                                            <td id="aktif"><a href="{{ route('rekap_status', ['status'=>'aktif']) }}" class="text-decoration-none">Aktif</a></td>
                                            <td id="2017"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2017', 'status'=>'aktif']) }}" class="text-decoration-none">{{ $mhs_count['2017']['aktif'] }}</a></td>
                                            <td id="2018"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2018', 'status'=>'aktif']) }}" class="text-decoration-none">{{ $mhs_count['2018']['aktif'] }}</a></td>
                                            <td id="2019"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2019', 'status'=>'aktif']) }}" class="text-decoration-none">{{ $mhs_count['2019']['aktif'] }}</a></td>
                                            <td id="2020"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2020', 'status'=>'aktif']) }}" class="text-decoration-none">{{ $mhs_count['2020']['aktif'] }}</a></td>
                                            <td id="2021"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2021', 'status'=>'aktif']) }}" class="text-decoration-none">{{ $mhs_count['2021']['aktif'] }}</a></td>
                                            <td id="2022"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2022', 'status'=>'aktif']) }}" class="text-decoration-none">{{ $mhs_count['2022']['aktif'] }}</a></td>
                                            <td id="2023"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2023', 'status'=>'aktif']) }}" class="text-decoration-none">{{ $mhs_count['2023']['aktif'] }}</a></td>
                                        </tr>
                                        <tr>
                                            <td id="do"><a href="{{ route('rekap_status', ['status'=>'drop out']) }}" class="text-decoration-none">DO</a></td>
                                            <td id="2017"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2017', 'status'=>'drop out']) }}" class="text-decoration-none">{{ $mhs_count['2017']['drop out'] }}</a></td>
                                            <td id="2018"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2018', 'status'=>'drop out']) }}" class="text-decoration-none">{{ $mhs_count['2018']['drop out'] }}</a></td>
                                            <td id="2019"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2019', 'status'=>'drop out']) }}" class="text-decoration-none">{{ $mhs_count['2019']['drop out'] }}</a></td>
                                            <td id="2020"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2020', 'status'=>'drop out']) }}" class="text-decoration-none">{{ $mhs_count['2020']['drop out'] }}</a></td>
                                            <td id="2021"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2021', 'status'=>'drop out']) }}" class="text-decoration-none">{{ $mhs_count['2021']['drop out'] }}</a></td>
                                            <td id="2022"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2022', 'status'=>'drop out']) }}" class="text-decoration-none">{{ $mhs_count['2022']['drop out'] }}</a></td>
                                            <td id="2023"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2023', 'status'=>'drop out']) }}" class="text-decoration-none">{{ $mhs_count['2023']['drop out'] }}</a></td>
                                        </tr>
                                        <tr>
                                            <td id="mangkir"><a href="{{ route('rekap_status', ['status'=>'mangkir']) }}" class="text-decoration-none">Mangkir</a></td>
                                            <td id="2017"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2017', 'status'=>'mangkir']) }}" class="text-decoration-none">{{ $mhs_count['2017']['mangkir'] }}</a></td>
                                            <td id="2018"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2018', 'status'=>'mangkir']) }}" class="text-decoration-none">{{ $mhs_count['2018']['mangkir'] }}</a></td>
                                            <td id="2019"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2019', 'status'=>'mangkir']) }}" class="text-decoration-none">{{ $mhs_count['2019']['mangkir'] }}</a></td>
                                            <td id="2020"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2020', 'status'=>'mangkir']) }}" class="text-decoration-none">{{ $mhs_count['2020']['mangkir'] }}</a></td>
                                            <td id="2021"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2021', 'status'=>'mangkir']) }}" class="text-decoration-none">{{ $mhs_count['2021']['mangkir'] }}</a></td>
                                            <td id="2022"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2022', 'status'=>'mangkir']) }}" class="text-decoration-none">{{ $mhs_count['2022']['mangkir'] }}</a></td>
                                            <td id="2023"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2023', 'status'=>'mangkir']) }}" class="text-decoration-none">{{ $mhs_count['2023']['mangkir'] }}</a></td>
                                        </tr>
                                        <tr>
                                            <td id="cuti"><a href="{{ route('rekap_status', ['status'=>'cuti']) }}" class="text-decoration-none">Cuti</a></td>
                                            <td id="2017"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2017', 'status'=>'cuti']) }}" class="text-decoration-none">{{ $mhs_count['2017']['cuti'] }}</a></td>
                                            <td id="2018"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2018', 'status'=>'cuti']) }}" class="text-decoration-none">{{ $mhs_count['2018']['cuti'] }}</a></td>
                                            <td id="2019"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2019', 'status'=>'cuti']) }}" class="text-decoration-none">{{ $mhs_count['2019']['cuti'] }}</a></td>
                                            <td id="2020"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2020', 'status'=>'cuti']) }}" class="text-decoration-none">{{ $mhs_count['2020']['cuti'] }}</a></td>
                                            <td id="2021"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2021', 'status'=>'cuti']) }}" class="text-decoration-none">{{ $mhs_count['2021']['cuti'] }}</a></td>
                                            <td id="2022"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2022', 'status'=>'cuti']) }}" class="text-decoration-none">{{ $mhs_count['2022']['cuti'] }}</a></td>
                                            <td id="2023"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2023', 'status'=>'cuti']) }}" class="text-decoration-none">{{ $mhs_count['2023']['cuti'] }}</a></td>
                                        </tr>
                                        <tr>
                                            <td id="lulus"><a href="{{ route('rekap_status', ['status'=>'lulus']) }}" class="text-decoration-none">Lulus</a></td>
                                            <td id="2017"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2017', 'status'=>'lulus']) }}" class="text-decoration-none">{{ $mhs_count['2017']['lulus'] }}</a></td>
                                            <td id="2018"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2018', 'status'=>'lulus']) }}" class="text-decoration-none">{{ $mhs_count['2018']['lulus'] }}</a></td>
                                            <td id="2019"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2019', 'status'=>'lulus']) }}" class="text-decoration-none">{{ $mhs_count['2019']['lulus'] }}</a></td>
                                            <td id="2020"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2020', 'status'=>'lulus']) }}" class="text-decoration-none">{{ $mhs_count['2020']['lulus'] }}</a></td>
                                            <td id="2021"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2021', 'status'=>'lulus']) }}" class="text-decoration-none">{{ $mhs_count['2021']['lulus'] }}</a></td>
                                            <td id="2022"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2022', 'status'=>'lulus']) }}" class="text-decoration-none">{{ $mhs_count['2022']['lulus'] }}</a></td>
                                            <td id="2023"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2023', 'status'=>'lulus']) }}" class="text-decoration-none">{{ $mhs_count['2023']['lulus'] }}</a></td>
                                        </tr>
                                        <tr>
                                            <td id="undur diri"><a href="{{ route('rekap_status', ['status'=>'undur diri']) }}" class="text-decoration-none">Undur Diri</a></td>
                                            <td id="2017"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2017', 'status'=>'undur diri']) }}" class="text-decoration-none">{{ $mhs_count['2017']['undur diri'] }}</a></td>
                                            <td id="2018"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2018', 'status'=>'undur diri']) }}" class="text-decoration-none">{{ $mhs_count['2018']['undur diri'] }}</a></td>
                                            <td id="2019"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2019', 'status'=>'undur diri']) }}" class="text-decoration-none">{{ $mhs_count['2019']['undur diri'] }}</a></td>
                                            <td id="2020"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2020', 'status'=>'undur diri']) }}" class="text-decoration-none">{{ $mhs_count['2020']['undur diri'] }}</a></td>
                                            <td id="2021"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2021', 'status'=>'undur diri']) }}" class="text-decoration-none">{{ $mhs_count['2021']['undur diri'] }}</a></td>
                                            <td id="2022"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2022', 'status'=>'undur diri']) }}" class="text-decoration-none">{{ $mhs_count['2022']['undur diri'] }}</a></td>
                                            <td id="2023"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2023', 'status'=>'undur diri']) }}" class="text-decoration-none">{{ $mhs_count['2023']['undur diri'] }}</a></td>
                                        </tr>
                                        <tr>
                                            <td id="meninggal"><a href="{{ route('rekap_status', ['status'=>'meninggal']) }}" class="text-decoration-none">Meninggal</a></td>
                                            <td id="2017"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2017', 'status'=>'meninggal']) }}" class="text-decoration-none">{{ $mhs_count['2017']['meninggal'] }}</a></td>
                                            <td id="2018"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2018', 'status'=>'meninggal']) }}" class="text-decoration-none">{{ $mhs_count['2018']['meninggal'] }}</a></td>
                                            <td id="2019"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2019', 'status'=>'meninggal']) }}" class="text-decoration-none">{{ $mhs_count['2019']['meninggal'] }}</a></td>
                                            <td id="2020"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2020', 'status'=>'meninggal']) }}" class="text-decoration-none">{{ $mhs_count['2020']['meninggal'] }}</a></td>
                                            <td id="2021"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2021', 'status'=>'meninggal']) }}" class="text-decoration-none">{{ $mhs_count['2021']['meninggal'] }}</a></td>
                                            <td id="2022"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2022', 'status'=>'meninggal']) }}" class="text-decoration-none">{{ $mhs_count['2022']['meninggal'] }}</a></td>
                                            <td id="2023"><a href="{{ route('rekap_tahun_status', ['angkatan'=>'2023', 'status'=>'meninggal']) }}" class="text-decoration-none">{{ $mhs_count['2023']['meninggal'] }}</a></td>
                                        </tr>

                                    </tbody>
                                  </table>
                                </div>
                                {{-- button  --}}
                                <br><br>
                                <button type="button" class="btn btn-primary btn-rounded btn-fw float-right" >Cetak</button>
                              </div>
                            </div>
                          </div>
                    </div>
            </div>
        </div>
    </main>
</div>

@endsection