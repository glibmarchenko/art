<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\Notification;
    use Illuminate\Http\Request;


    class NotificationController extends Controller
    {
        public function getUserNotifications(Request $request)
        {
            return $request->user()->notifications;
        }

        public function setAllUserNotificationsChecked(Request $request)
        {
            foreach ($request->user()->notifications as $notification) {
                $notification->checked = 1;
                $notification->save();
            }
            return $request->user()->notifications;
        }

        public function setUserNotificationChecked($id, Request $request)
        {
            $notification = Notification::findOrFail($id);
            if ($notification->user_id !== $request->user()->id) {
                throw new \Exception('Not Authorized');
            }
            $notification->checked = 1;
            $notification->save();
            return $notification;
        }
    }