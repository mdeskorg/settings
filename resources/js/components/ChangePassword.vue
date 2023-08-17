<template>
    <form @submit.prevent="changePassword" class="space-y-8" autocomplete="off">
        <div class="space-y-4">
            <div>
                <h1 class="font-normal text-xl md:text-xl mt-3 mb-3">
                    {{ __("Change Password") }}
                </h1>
                <!---->
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow divide-y divide-gray-100 dark:divide-gray-700"
                >
                    <!-- FIELD -->
                    <div class="md:flex md:flex-row space-y-2 md:space-y-0 py-5">
                        <div
                            class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5"
                        >
                            <label
                                for="current-password"
                                class="inline-block pt-2 leading-tight"
                                >{{ __("Current Password") }}
                                <span class="text-red-500 text-sm"
                                    >*</span
                                ></label
                            >
                        </div>
                        <div
                            class="mt-1 md:mt-0 pb-5 px-6 md:px-8 md:w-3/5 w-full md:py-5"
                        >
                            <div class="space-y-1">
                                <input
                                    type="password"
                                    v-model="form.currentPassword"
                                    :placeholder="__('Current Password')"
                                    class="w-full form-control form-input form-input-bordered"
                                    :class="{
                                        'form-input-border-error':
                                            form.errors.has('currentPassword'),
                                    }"
                                    id="current-password"
                                    required
                                    min="8"
                                />
                                <HelpText
                                    class="mt-2 text-red-500"
                                    v-if="form.errors.has('currentPassword')"
                                >
                                    {{ form.errors.first("currentPassword") }}
                                </HelpText>
                            </div>
                        </div>
                    </div>
                    <!-- FIELD -->
                    <div class="md:flex md:flex-row space-y-2 md:space-y-0 py-5">
                        <div
                            class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5"
                        >
                            <label
                                for="new-password"
                                class="inline-block pt-2 leading-tight"
                                >{{ __("New Password") }}
                                <span class="text-red-500 text-sm"
                                    >*</span
                                ></label
                            >
                        </div>
                        <div
                            class="mt-1 md:mt-0 pb-5 px-6 md:px-8 md:w-3/5 w-full md:py-5"
                        >
                            <div class="space-y-1">
                                <input
                                    type="password"
                                    v-model="form.password"
                                    :placeholder="__('New Password')"
                                    class="w-full form-control form-input form-input-bordered"
                                    :class="{
                                        'form-input-border-error':
                                            form.errors.has('password'),
                                    }"
                                    id="new-password"
                                    required
                                    min="8"
                                />
                                <HelpText
                                    class="mt-2 text-red-500"
                                    v-if="form.errors.has('password')"
                                >
                                    {{ form.errors.first("password") }}
                                </HelpText>
                            </div>
                        </div>
                    </div>
                    <!-- FIELD -->
                    <div class="md:flex md:flex-row space-y-2 md:space-y-0 py-5">
                        <div
                            class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5"
                        >
                            <label
                                for="repeat-password"
                                class="inline-block pt-2 leading-tight"
                                >{{ __("Repeat Password") }}
                                <span class="text-red-500 text-sm"
                                    >*</span
                                ></label
                            >
                        </div>
                        <div
                            class="mt-1 md:mt-0 pb-5 px-6 md:px-8 md:w-3/5 w-full md:py-5"
                        >
                            <div class="space-y-1">
                                <input
                                    type="password"
                                    v-model="form.password_confirmation"
                                    :placeholder="__('Repeat Password')"
                                    class="w-full form-control form-input form-input-bordered"
                                    :class="{
                                        'form-input-border-error':
                                            form.errors.has(
                                                'password_confirmation'
                                            ),
                                    }"
                                    id="repeat-password"
                                    required
                                    min="8"
                                />
                                <HelpText
                                    class="mt-2 text-red-500"
                                    v-if="
                                        form.errors.has('password_confirmation')
                                    "
                                >
                                    {{
                                        form.errors.first(
                                            "password_confirmation"
                                        )
                                    }}
                                </HelpText>
                            </div>
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
                    {{ __("Change") }}
                </span>
            </LoadingButton>
        </div>
    </form>
</template>

<script>
import { Errors } from "laravel-nova";

export default {
    data() {
        return {
            form: Nova.form({
                currentPassword: "",
                password: "",
                password_confirmation: "",
            }),
            validationErrors: new Errors(),
        };
    },

    methods: {
        async changePassword() {
            try {
                const response = await this.form.post(
                    "/nova-vendor/settings/change-password"
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
