<template>
    <loading-view :loading="loading">
        <div>
            <Head :title="__('Settings')" />

            <UpdateInfo :parameters="props" />
            <ChangePassword />
        </div>
    </loading-view>
</template>

<script>
import UpdateInfo from "../components/UpdateInfo";
import ChangePassword from "../components/ChangePassword";

export default {
    components: {
        UpdateInfo,
        ChangePassword,
    },

    data: () => ({
        props: [],
        loading: true,
    }),

    async created() {
        this.getProps();
    },

    methods: {
        async getProps() {
            const {
                data: { props },
            } = await Nova.request()
                .get(`/nova-vendor/settings`)
                .catch((error) => {
                    if (error.response.status == 404) {
                        Nova.visit("/404");
                        return;
                    }
                });

            this.props = props;
            this.loading = false;
        },
    },
};
</script>
