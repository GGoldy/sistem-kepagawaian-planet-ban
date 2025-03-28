<div class="d-flex">
    <a href="{{ route('ketidakhadirans.approvalHCM', ['id' => $ketidakhadiran->id]) }}"
        class="btn btn-outline-dark btn-sm me-2"><i class="fas fa-fw fa-book"></i></a>
    <div>
        {{-- <form action="{{ route('ketidakhadirans.signApprovalHCM', ['id' => $ketidakhadiran->id]) }}" method="POST">
            @csrf
            @method('put')
            <button type="submit" class="btn btn-outline-dark btn-sm me-2 btn-approve">
                <i class="fas fa-fw fa-check-square"></i>
            </button>
        </form> --}}
    </div>
</div>
