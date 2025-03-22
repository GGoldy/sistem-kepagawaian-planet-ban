<div class="d-flex">
    <a href="{{ route('lokasikerjas.show', ['lokasikerja' => $lokasi_kerja->id]) }}" class="btn btn-outline-dark btn-sm me-2"><i
            class="fas fa-fw fa-book"></i></a>
    <a href="{{ route('lokasikerjas.edit', ['lokasikerja' => $lokasi_kerja->id]) }}" class="btn btn-outline-dark btn-sm me-2"><i
            class="fas fa-fw fa-pencil-alt"></i></a>
    <div>
        <form action="{{ route('lokasikerjas.destroy', ['lokasikerja' => $lokasi_kerja->id]) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-outline-dark btn-sm me-2 btn-delete" data-name="{{ $lokasi_kerja->nama }}">
                <i class="fas fa-fw fa-trash-alt"></i>
            </button>
        </form>

    </div>
</div>
