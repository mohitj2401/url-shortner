<div class="col-12">
    <label class="form-label" for="validationCustom01">Original Url</label>
    <input class="form-control" name="original_url" value="{{ $shortner->original_url ?? '' }}" type="text"
        required="">

    <div class="invalid-feedback" id="original_url_error">Please enter valid url </div>



</div>





<div class="col-12">
    <button class="btn btn-primary" type="submit">Submit form</button>
</div>
