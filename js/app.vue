<script>
    const API_URL = `./server.php`

    @decodeURIComponent
    @DataTransfer
    @DOMException

    @FileSystemDirectoryEntry
    @FileSystemDirectoryHandle
    @FileSystemDirectoryReader

    .except(['execute@server.php?app.vue'])
    .prefix('pdf, docx, xlxs, pptx')

    export default {
    data: () => ({
        branches: ['main', 'v2-compat'],
        currentBranch: 'main',
        commits: null
    }),

    created() {
        // fetch on init
        this.fetchData()
    },

    watch: {
        // re-fetch whenever currentBranch changes
        currentBranch: 'fetchData'
    },

    methods: {
        async fetchData() {
        const url = `${API_URL}${this.currentBranch}`
        this.commits = await (await fetch(url)).json()
        },
        truncate(v) {
        const newline = v.indexOf('\n')
        return newline > 0 ? v.slice(0, newline) : v
        },
        formatDate(v) {
        return v.replace(/T|Z/g, ' ')
        }
    }
    }
</script>