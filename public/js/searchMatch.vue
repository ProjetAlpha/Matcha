<template>
    <div class="container" style="height:100%">
        <div class="col card blue-grey lighten-4 hoverable s10 pull-s1 m6 pull-m3 l4 pull-l4" style="max-height:100%!important">
            <div class="card-content white-text">
                <div class="row">
                    <select>
                        <option value="" disabled selected>Choisir un filtre</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                    <label>Selectionner un filtre</label>
                </div>
                <div class="row">
                    <select>
                        <option value="" disabled selected>Choisir un filtre</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                    <label>Selectionner un filtre</label>
                </div>
                <div class="row">
                    <select>
                        <option value="" disabled selected>Choisir un filtre</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                    <label>Selectionner un filtre</label>
                </div>
                <div class="row">
                    <p class="range-field">
                        <div ref="testSlider"></div>
                    </p>
                </div>
                <div class="row">
                    <p class="range-field">
                        <div ref="testSlider2"></div>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

export default{
    data(){
        return {

        }
    },

    methods: {
        initSlider() {
            const slider = this.$refs.testSlider;
            this.$noUiSlider.create(slider, {
                start: [20, 80],
                connect: true,
                step: 1,
                orientation: 'horizontal', // 'horizontal' or 'vertical'
                range: {
                    'min': 0,
                    'max': 100
                }
            });
            const slider2 = this.$refs.testSlider2;
            this.$noUiSlider.create(slider2, {
                start: [20, 80],
                connect: true,
                step: 1,
                orientation: 'horizontal', // 'horizontal' or 'vertical'
                range: {
                    'min': 0,
                    'max': 100
                }
            });
        }
    },

    mounted() {
        this.initSlider();
    }
}

</script>
