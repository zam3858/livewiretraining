<div>
    <h1>Kiraan Zakat untuk {{ $nama }}</h1>
    <h3>Kadar Zakat Semasa: {{ $kadarZakat }}</h3>
    <hr>
    <button wire:click="toggleDetail" class="btn btn-warning m-2"> Detail </button>
    <div>
        @if($showDetail)
            Nama: {{ $nama }} <br>
            Age: {{ $age }} <br>
            Job: {{ $kerja }}
        @endif
    </div>
    <hr>
    <div>
        <label for="jumlahPendapatan"> Jumlah Pendapatan </label>
        <input type="text" name="jumlahPendapatan" id="jumlahPendapatan"
               wire:model.defer="jumlahPendapatan"
               class="form-control" />
    </div>
    <div>
        <button wire:click="kiraZakat" class="btn btn-primary m-2"> Kira Zakat </button>
        <button wire:click="resetJumlahPendapatan" class="btn btn-warning m-2"> Reset </button>
    </div>
    <div>
        Formula: Jumlah Pendapatan ({{ $jumlahPendapatan }})
                            * Kadar Zakat ({{ $kadarZakat }}) %
        <br>
        Jumlah Zakat Pendapatan Anda: MYR {{ $hasilKiraanZakat }}
    </div>
    <div>
        {{ $statusKiraan }}
    </div>
</div>
