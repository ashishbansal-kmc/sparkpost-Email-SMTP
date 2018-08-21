# Sparkpost
In with curl method, send emails to multiple users.
All emails for To, Cc, Bcc will be added to recipients list. For Cc add [headers][CC] in content in body. 
Sample headers for CC.

'headers'=>
[
  "CC"=>"<cc@example.com>"
],


Format to set Emails:

$sample_address=[
        [
            'address' => [
                'name' => 'name',
                'email' => 'to1@example.com',
            ],
        ],

        [
            'address' => [
                'name' => 'name',
                'email' => 'to2@example.com',
            ],
        ],

        [
            'address' => [
                'name' => 'name',
                'email' => 'cc1@example.com',
            ],
        ],

        [
            'address' => [
                'name' => 'name',
                'email' => 'cc2@example.com',
            ],
        ],

        [
            'address' => [
                'name' => 'name',
                'email' => 'bcc1@example.com',
            ],
        ],

        [
            'address' => [
                'name' => 'name',
                'email' => 'bcc2@example.com',
            ],
        ],

    ];
