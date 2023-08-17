<template>
    <form @submit.prevent="updateInfo" class="space-y-8" autocomplete="off">
        <div class="space-y-4">
            <div>
                <h1 class="font-normal text-xl md:text-xl mb-3">
                    {{ __("Settings") }}
                </h1>
                <!---->
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow divide-y divide-gray-100 dark:divide-gray-700"
                >

             
                    <div class="md:flex md:flex-row space-y-2 md:space-y-0 py-5">
                        <div
                            class="w-full md:mt-2 px-6 md:px-8 md:w-1/5"
                        >
                            <label
                                for="title-sozdat-proekt-text-field"
                                class="inline-block leading-tight space-x-1"
                                >{{ __("Name") }}
                                <span class="text-red-500 text-sm">*</span
                                ><!--v-if--></label
                            >
                        </div>
                        <div
                            class="w-full space-y-2 px-6 md:px-8 md:w-3/5"
                        >
                            <div class="space-y-1">
                                <input
                                    type="text"
                                    v-model="form.name"
                                    :placeholder="__('Name')"
                                    class="w-full form-control form-input form-input-bordered"
                                    :class="{
                                        'form-input-border-error':
                                            form.errors.has('name'),
                                    }"
                                    id="title-sozdat-proekt-text-field"
                                    dusk="title"
                                    required
                                    maxlength="32"
                                />
                                <HelpText
                                    class="mt-2 text-red-500"
                                    v-if="form.errors.has('name')"
                                >
                                    {{ form.errors.first("name") }}
                                </HelpText>
                            </div>
                        </div>
                    </div>
                    <div class="md:flex md:flex-row space-y-2 md:space-y-0 py-5">
                        <div
                            class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5"
                        >
                            <span class="inline-block pt-2 leading-tight"
                                >{{ __("Email") }}
                                <!--v-if--></span
                            >
                        </div>
                        <div
                            class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5"
                        >
                            <span class="inline-block pt-2 leading-tight">
                                {{ form.email }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="flex flex-col md:flex-row md:items-center justify-center md:justify-end space-y-2 md:space-y-0 space-x-3"
        >
            <LoadingButton
                class="flex justify-center"
                type="submit"
                :disabled="form.processing"
                :loading="form.processing"
            >
                <span>
                    {{ __("Save") }}
                </span>
            </LoadingButton>
        </div>
    </form>
</template>

<script>
import { Errors } from "laravel-nova";

export default {
    props: ["parameters"],

    data() {
        return {
            form: Nova.form(this.parameters),
            validationErrors: new Errors(),
        };
    },

    methods: {
        async updateInfo() {
            try {
                const response = await Nova.request().post(
                    "/nova-vendor/settings/set-info",
                    this.form
                );

                Nova.$toasted.show(this.__("Updated"), {
                    type: "success",
                });

                this.form.errors = new Errors();
            } catch (error) {
                if (error.response?.status === 500) {
                    Nova.error(
                        this.__("There was a problem submitting the form.")
                    );
                }

                this.form.errors = new Errors(error.response.data.errors);
            }
        },
    },
};
</script>
