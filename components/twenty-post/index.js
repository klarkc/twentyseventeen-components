export default {
    template: '#twenty-post',
    data: function() {
        return {
            loading: false
        }
    },
    mounted: function() {
        setTimeout(function() {
            this.loading = true
        }, 3000)
    }
}