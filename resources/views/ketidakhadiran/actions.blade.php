<div class="d-flex">
    <a href="{{ route('ketidakhadirans.show', ['ketidakhadiran' => $ketidakhadiran->id]) }}" class="btn btn-outline-dark btn-sm me-2"><i
            class="fas fa-fw fa-book"></i></a>
    <a href="{{ route('ketidakhadirans.edit', ['ketidakhadiran' => $ketidakhadiran->id]) }}" class="btn btn-outline-dark btn-sm me-2"><i
            class="fas fa-fw fa-pencil-alt"></i></a>
    <div>
        <form action="{{ route('ketidakhadirans.destroy', ['ketidakhadiran' => $ketidakhadiran->id]) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-outline-dark btn-sm me-2 btn-delete">
                <i class="fas fa-fw fa-trash-alt"></i>
            </button>
        </form>

    </div>
</div>
