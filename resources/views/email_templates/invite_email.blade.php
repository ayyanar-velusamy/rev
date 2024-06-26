<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Revival</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
        <style>
            table{
                font-family: Arial, sans-serif;
                font-size: 15px;
                line-height: 1.75;
                color: #23496d;
            }
            @media only screen and (max-width: 767px){
                table{
                    width:100% !important; 
                    font-size: 12px;
                }
            } 
        </style>
    </head>
        
    <body style="margin:0;" margin="0" padding="0">
            <table align="center" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" width="700px" style=" border: 1px solid #f2f2f2; border-top:6px solid #384f98;">
                <tr> 
                    <td align="center" style="padding: 13px 0 13px 0; ">
                        <a href="{{url('/')}}" target="_blank">
                            <img src="{{asset('images/template/revlogo.png') }}" alt="rev logo"/>
                        </a>
                    </td>
                </tr>
                 <tr>
                    <td>
                        <div class="banner" style="position:relative;">
							<img src="{{asset('images/template/rev_banner.png') }}" alt="rev Banner"/>
							<h1 style="color:#fff; font-size:35px; position:absolute; left:0px;right:0px; text-align:center; top:20%;"><span style="display:block; color:#bbdc00; font-size:20px; line-height:20px;height: 20px;">Welcome To</span> Revival </h1>
						<div>
                    </td>
                </tr>
				
				<tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="padding:30px 27px 30px 27px">
                            <tbody>
                                <tr>
                                    <td style="padding-bottom:25px;">
                                        <h3 style="font-size: 24px; color:#384f98;font-weight: 400; text-align:center; padding:0 0 10px; margin:0px;">Dear {{ $user->first_name." ".$user->last_name }},</h3>
                                        <span style="border-bottom:1px solid #384f98; max-width:50px; display:block; margin:0 auto;"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom:30px; ">
                                        <span style="text-align:center; max-width:520px; display:block; margin:0 auto; font-size: 14px;color:#323232;">Please use the link below to set password for your new account.</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom:40px;">
                                        <a href="{{ $link }}" style=" border-radius:50px; text-decoration:none; text-align:center; background:#bbdc00; font-size:15px; font-weight:bold; color:#5a5a5a; max-width:240px; line-height:50px; display:block; margin:0 auto;"> Set Password</a>
                                    </td>
                                </tr>
								<tr>
                                   <td style="padding-bottom:10px;">
                                         <span style="text-align:left; display:block; margin:0 auto; font-size: 14px;color:#323232;">Thanks,</span>
                                         <span style="text-align:left; display:block; margin:0 auto; font-size: 14px;color:#323232;">Revival</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="background-color: #384f98; padding: 5px 0;  text-align: center;">
                       <span style="font-size: 13px; color:#fff;"> &copy; {{ date('Y')}} {{ env('APP_NAME','') }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>