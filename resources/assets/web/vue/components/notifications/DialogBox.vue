<template>
    <section
            id="saved-modal-section"
            class="popup"
            v-if="isVisible">
        <!-- Modal -->
        <div
                class="modal"
                id="saved-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <h2 class="modal-heading">{{ content.heading }}</h2>
                    <p v-html="content.text"></p>

                    <a
                            :href="'/user/profile'"
                            v-if="content.showProfileButton">
                        <button
                                class="btn btn-full-width btn-fill-green btn-m-89"
                                @click="hide()">
                            {{ trans('account.Profile') }}
                        </button>
                    </a>

                    <a>
                        <button
                                class="btn btn-full-width btn-fill-red btn-d-34 btn-m-89"
                                v-if="content.showCancel"
                                @click="isVisible = false">{{ trans('dashboard.Cancel') }}
                        </button>
                    </a>

                    <a>
                        <button class="btn btn-full-width btn-fill-green btn-d-34 btn-m-89" @click="hide()">{{
                            trans('account.Continue')
                            }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>


<script>
    import {EventBus} from './../../event-bus.js';

    export default {
        data() {
            return {
                isVisible: false,
                profileButton: true,
                template: 'save',
                templates: {
                    save: {
                        showProfileButton: false,
                        heading: trans('account.work_saved'),
                        text: trans('account.will_checked')
                    },
                    update: {
                        showProfileButton: false,
                        heading: trans('account.work_changed'),
                        text: trans('account.work_changed')
                    },
                    delete: {
                        showProfileButton: false,
                        heading: trans('account.work_deleted'),
                        text: trans('account.fully_deleted')
                    },
                    delete_confirmation: {
                        showCancel: true,
                        showProfileButton: false,
                        heading: trans('account.delete_work?'),
                        text: trans('account.will_deleted')
                    },
                    gallery_update: {
                        showCancel: false,
                        showProfileButton: false,
                        heading: trans('account.profile_updated'),
                        text: trans('account.changes_saved')
                    },
                    registration_success: {
                        showCancel: false,
                        showProfileButton: false,
                        heading: trans('account.success_register'),
                        text: trans('account.email_link')
                    },
                    cant_submit: {
                        showCancel: false,
                        showProfileButton: false,
                        heading: trans('account.cant_submit_heading'),
                        text: trans('account.cant_submit_text')
                    },
                    purchase_warning: {
                        showCancel: false,
                        showProfileButton: false,
                        heading: trans('account.attention'),
                        text: trans('account.exhibition_') +
                            trans('account.availability') +
                            trans('account.author_confirms') +
                            trans('account.payment_bill')
                    },
                    // print_payment_success: {
                    //     showCancel: false,
                    //     showProfileButton: false,
                    //     heading: trans('account.payment.print.success.heading'),
                    //     text: trans('account.payment.print.success.text')
                    // },
                    // print_payment_error: {
                    //     showCancel: false,
                    //     showProfileButton: false,
                    //     heading: trans('account.payment.print.error.heading'),
                    //     text: trans('account.payment.print.error.text')
                    // },
                    // other_payment_success: {
                    //     showCancel: false,
                    //     showProfileButton: false,
                    //     heading: trans('account.payment.other.success.heading'),
                    //     text: trans('account.payment.other.success.text')
                    // },
                    // other_payment_error: {
                    //     showCancel: false,
                    //     showProfileButton: false,
                    //     heading: trans('account.payment.other.error.heading'),
                    //     text: trans('account.payment.other.error.text')
                    // },
                    purchase_initiated: {
                        showCancel: false,
                        showProfileButton: false,
                        heading: trans('account.payment.all.success.heading'),
                        text: trans('account.payment.all.success.text')
                    },
                }
            }
        },
        computed: {
            content: function () {
                return this.templates[this.template];
            }
        },
        created() {
            this.checkDisplay();

            let that = this;
            EventBus.$on('dialog-popup', function (dialog_type) {
                console.log('on dialog popup');
                console.log(dialog_type);
                that.template = dialog_type;
                console.log(that.template);
                if (typeof that.template === 'string') {
                    console.log('show?');
                    that.isVisible = true;
                    console.log(that.template);
                }
            });
        },
        methods: {
            hide() {
                if (this.template === 'delete_confirmation') {
                    EventBus.$emit('delete_confirmed');
                }
                this.isVisible = false;
            },
            checkDisplay() {
                this.template = window.sessionStorage.getItem('dialog-box');
                if (typeof this.template === 'string') {
                    window.sessionStorage.removeItem('dialog-box');
                    this.isVisible = true;
                }
            }
        }
    }
</script>
