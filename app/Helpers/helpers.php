<?php
use App\Models\User;
use App\Models\Liturgical;
use App\Notifications\NotifyUser;
use Illuminate\Support\Facades\Auth;

if (!function_exists('format_date')) {
    /**
     * Format a date into 'Y-m-d' format.
     *
     * @param string|null $date
     * @return string|null
     */
    function format_date($date)
    {
        return $date ? date('Y-m-d', strtotime($date)) : null;
    }
}

if (!function_exists('get_all_priest')) {
    /**
     * Retrieve all users with the role of 'priest' or 'parish_priest'.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_all_priest()
    {
        return \App\Models\User::whereIn('role', ['priest', 'parish_priest'])->get();
    }
}



if (!function_exists('get_all_notifications')) {
    /**
     * Get all notifications (both read and unread) for the authenticated user.
     *
     * @return array
     */
    function get_all_notifications()
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            // Get all notifications (both unread and read)
            $notifications = auth()->user()->notifications; // Fetches both read and unread

            // Return notifications as an array
            return $notifications->toArray();
        }

        return []; // Return an empty array if the user is not authenticated
    }
}

if (!function_exists('get_all_liturgical')) {
    /**
     * Format a date into 'Y-m-d' format.
     *
     * @param string|null $date
     * @return string|null
     */
    function get_all_liturgical()
    {
        return Liturgical::orderBy('id', 'desc')->get();
    }
}

if (!function_exists('get_count_notify')) {
    /**
     * Format a date into 'Y-m-d' format.
     *
     * @param string|null $date
     * @return string|null
     */
    function get_count_notify()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get the count of unread notifications
        $unreadCount = $user->unreadNotifications()->count();

        // Return the unread count in response
        return $unreadCount;
    }
}

if (!function_exists('send_notification')) {
    /**
     * Format a date into 'Y-m-d' format.
     *
     * @param string|null $date
     * @return string|null
     */
    // function sendNotification($param)
    // {

    //     if ($param['type'] == 'all') {
    //         # code...
    //         $user = User::all();
    //     }else{
    //         $user = User::where('role',$param['where'])->get();
    //     }
      
    //     // Data to be included in the notification
    //     // $data = [
    //     //     'type' => 'all',
    //     //     'image_path' => '/images/sample.jpg',
    //     //     'name' => 'John Doe',
    //     //     'user' => 'john.doe@example.com',
    //     //     'title' => 'Sample Notification Title',
    //     //     'url' => '/',
    //     //     'where' => '',
    //     // ];


    //     $user->notify(new NotifyUser($param));

 
    //     $notification = $user->notifications()->latest()->first();

    //     $response = [
    //         'image_path' => $notification->data['image_path'],
    //         'name' => $notification->data['name'],
    //         'user' => $notification->data['user'],
    //         'title' => $notification->data['title'],
    //         'url' => $notification->data['url'],
    //         'datetime' => $notification->created_at->diffForHumans(), // Human-readable datetime
    //     ];

    //     return response()->json($response);
    // }

    function send_notification($param)
    {
        if ($param['type'] == 'all') {
            $users = User::all(); 
        } else {
            $users = User::whereIn('id', $param['where'])->get(); 
        }

        foreach ($users as $user) {
            $user->notify(new NotifyUser($param));
        }

        if ($users->isNotEmpty()) {
            $latestNotification = $users->first()->notifications()->latest()->first();

            $response = [
                'type' => $latestNotification->data['type'] ?? '',
                'image_path' => $latestNotification->data['image_path'] ?? '',
                'name' => $latestNotification->data['name'] ?? '',
                'user' => $latestNotification->data['user'] ?? '',
                'title' => $latestNotification->data['title'] ?? '',
                'url' => $latestNotification->data['url'] ?? '',
                'description' => $latestNotification->data['description'] ?? '',
                'datetime' => $latestNotification->created_at->diffForHumans(),
                'where' => $latestNotification->data['where'] ?? '',
            ];

            return response()->json($response);
        }

        return response()->json(['message' => 'No users to notify.']);
    }

}

