<div class="row">
    <div class="col-lg-7 col-lg-offset-2 col-md-12 text-right">
        <button
            type="submit"
            class="btn btn-primary"
            :class="{
                'btn-loading': formSubmitting
            }"
            :disabled="formSubmitting"
        >
            {{ trans('admin::admin.buttons.save') }}
        </button>
    </div>
</div>