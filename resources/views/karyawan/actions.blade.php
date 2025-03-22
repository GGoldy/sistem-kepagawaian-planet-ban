<div class="d-flex">
    <a href="{{ route('karyawans.show', ['karyawan' => $karyawan->id]) }}" class="btn btn-outline-dark btn-sm me-2"><i
            class="fas fa-fw fa-book"></i></a>
    <a href="{{ route('karyawans.edit', ['karyawan' => $karyawan->id]) }}" class="btn btn-outline-dark btn-sm me-2"><i
            class="fas fa-fw fa-pencil-alt"></i></a>
    <div>
        <form action="{{ route('karyawans.destroy', ['karyawan' => $karyawan->id]) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-outline-dark btn-sm me-2 btn-delete" data-name="{{ $karyawan->nama }}">
                <i class="fas fa-fw fa-trash-alt"></i>
            </button>
        </form>

    </div>
</div>
