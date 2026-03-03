<form id="emiForm" class="row g-3">
  @csrf
  <div class="col-md-4">
    <input type="number" class="form-control" id="amount" placeholder="Loan Amount">
  </div>
  <div class="col-md-4">
    <input type="number" step="0.01" class="form-control" id="rate" placeholder="Interest %">
  </div>
  <div class="col-md-4">
    <input type="number" class="form-control" id="months" placeholder="Months">
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-success">Calculate EMI</button>
  </div>
</form>

<div id="emiResult" class="mt-3"></div>

@push('scripts')
<script>
document.getElementById('emiForm').addEventListener('submit', function(e){
  e.preventDefault();

  fetch('/api/emi', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({
      amount: amount.value,
      rate: rate.value,
      months: months.value
    })
  })
  .then(res => res.json())
  .then(data => {
    emiResult.innerHTML = `
      <div class="alert alert-success">
        EMI: ₹${data.emi}<br>
        Total Payment: ₹${data.total}
      </div>`;
  });
});
</script>
@endpush