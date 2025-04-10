<div class="d-flex">
    <a href="{{ route('penilaians.show', ['penilaian' => $penilaian->id]) }}" class="btn btn-outline-dark btn-sm me-2"><i
            class="fas fa-fw fa-book"></i></a>
    <a href="{{ route('penilaians.edit', ['penilaian' => $penilaian->id]) }}" class="btn btn-outline-dark btn-sm me-2"><i
            class="fas fa-fw fa-pencil-alt"></i></a>
    <div>
        <form action="{{ route('penilaians.destroy', ['penilaian' => $penilaian->id]) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-outline-dark btn-sm me-2 btn-delete" data-name="{{ $penilaian->karyawan_id }}">
                <i class="fas fa-fw fa-trash-alt"></i>
            </button>
        </form>

    </div>
</div>
