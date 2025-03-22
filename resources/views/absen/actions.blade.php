<div class="d-flex">
    <a href="{{ route('absens.edit', ['absen' => $absen->id]) }}" class="btn btn-outline-dark btn-sm me-2"><i
            class="fas fa-fw fa-pencil-alt"></i></a>
    <div>
        <form action="{{ route('absens.destroy', ['absen' => $absen->id]) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-outline-dark btn-sm me-2 btn-delete">
                <i class="fas fa-fw fa-trash-alt"></i>
            </button>
        </form>

    </div>
</div>
