import Vue from "vue";
import VariationMixin from "./mixins/VariationMixin";
import { toaster } from "@admin/js/Toaster";

new Vue({
    el: "#app",

    mixins: [VariationMixin],

    created() {
        this.setFormDefaultData();
    },

    mounted() {
        this.focusInitialField();
    },

    methods: {
        setFormDefaultData() {
            this.form = {
                type: "",
                values: [
                    {
                        id: this.uid(),
                        label: "",
                        color: "",
                    },
                ],
            };
        },

        focusInitialField() {
            this.$nextTick(() => {
                $("#name").trigger("focus");
            });
        },
    },
});
