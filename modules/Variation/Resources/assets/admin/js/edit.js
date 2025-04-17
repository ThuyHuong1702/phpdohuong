import Vue from "vue";
import VariationMixin from "./mixins/VariationMixin";
import { toaster } from "@admin/js/Toaster";
 
// Vue.prototype.route = route;
 
new Vue({
    el: "#app",
 
    mixins: [VariationMixin],
 
    data() {
        return {
            form: {
                id: null,
                name: '',
                type: '',
                label: '',
                values: [],
            },
            formSubmitting: false,
            errors: {},
        };
    },
 
    created() {
        this.setFormDefaultData();
   
    },
 
    mounted() {
        this.initColorPicker();
        this.focusInitialField();
    },
 
    methods: {
        setFormDefaultData() {    
           
            this.form = Ecommerce.data["variation"];
        },
 
        focusInitialField() {
            this.$nextTick(() => {
                $("#name").trigger("focus");
            });
        },
    },
});
