<template>
    <span>
        <a href="#" class="show-notifications non-active" @click="toggle()">
            
            <img class="notif-icon" v-if="hasNew" src="/web/images/ui/notification-hover.svg">
            
            <img class="notif-icon" v-if="!hasNew" src="/web/images/ui/notification.svg">
            
            <div class="menu-trigger second notif-close">
                <span class="line line-1"></span>
                <span class="line line-2"></span>
                <span class="line line-3"></span>
            </div>
            
        </a>

        <section class="notifications-section">
            <div class="notif-top" :class="{ hasNoNew: !hasNew}">
                <a href="#">{{ hasNotChecked.length }} {{ trans('pages.new') }}</a>
                <a href="#" @click="setCheckedAll()">{{ trans('pages.Mark all') }}</a>
            </div>
            <div class="notifications-list">
                <a href="#" class="notification-row" v-bind:class="{ notifViewed: ifChecked(notification)}"
                   v-for="notification in notifications" @click="setChecked(notification)">
                    <div class="notif-message">
                        {{notification.text}}
                    </div>
                    <div class="notif-date">
                        {{notification.datetime}}
                    </div>
                </a>
            </div>
            <div class="notif-bottom">

            </div>
        </section>
    </span>
</template>


<script>
  import axios from 'axios'

  export default {
        data() {
            return {
                notifications: [],
                isNotificationDisplayed: false
            }
        },
        created() {
            this.fetchNotifications();
        },
        methods: {
            fetchNotifications: function () {
                axios.get('/api/v1/user/notification').then((res) => {
                    this.notifications = res.data;
                });
            },
            ifChecked(notification) {
                return !!notification.checked;
            },
            setChecked(notification) {
                axios.post('/api/v1/user/notification/checked/' + notification.id).then((res) => {
                    notification.checked = 1;
                });
            },
            setCheckedAll() {
                axios.post('/api/v1/user/notification/checked/all').then((res) => {
                    this.notifications = res.data;
                });
            },
            toggle() {
                this.isNotificationDisplayed ? this.hide() : this.show();
            },
            show() {
                $('.notifications-section').velocity('transition.bounceRightIn');
                $('.show-notifications').addClass('opened');
                $('.notif-close').addClass('active');
                this.isNotificationDisplayed = true;
            },
            hide() {
                $('.notifications-section').velocity('transition.bounceRightOut');
                $('.show-notifications').removeClass('opened');
                $('.notif-close').removeClass('active');
                this.isNotificationDisplayed = false;
            }

        },
        computed: {
            hasNotChecked: function () {
                return this.notifications.filter(notification => {
                    return notification.checked === 0
                })
            },
            hasNew: function() {
              return !!(this.hasNotChecked.length);
            }

        }


    }
</script>