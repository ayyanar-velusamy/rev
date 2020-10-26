<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>{{ env('APP_NAME','') }}</title>
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
                            <img src="{{asset('images/template/lxplogo.png') }}" alt="LXP logo"/>
                        </a>
                    </td>
                </tr>
                 <tr>
                    <td>
                        <div class="banner" style="position:relative;">
							<img src="{{asset('images/template/lxp_banner.png') }}" alt="LXP Banner"/>
							<h1 style="color:#fff; font-size:35px; position:absolute; left:0px;right:0px; text-align:center; top:20%;"><span style="display:block; color:#bbdc00; font-size:20px; line-height:20px;height: 20px;"></span> Learning Experience Platform </h1>
						<div>
                    </td>
                </tr>
				
				<tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="padding:30px 27px 30px 27px">
                            <tbody>
                                <tr>
                                    <td style="padding-bottom:25px;">
                                        <h3 style="font-size: 24px; color:#384f98;font-weight: 400; text-align:center; padding:0 0 10px; margin:0px;">Dear {{ $journey->user_name }},</h3>
                                        <span style="border-bottom:1px solid #384f98; max-width:50px; display:block; margin:0 auto;"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom:40px; ">
                                        <span style="text-align:center; max-width:520px; display:block; margin:0 auto; font-size: 14px;color:#323232;">{{$user_name}}  has revoked  the following Learning Journey. Please find below the Journey Details</span>
                                    </td>
                                </tr>
								<tr>
                                    <td style="padding-bottom:40px; ">
                                        <span style="text-align:center; max-width:520px; display:block; margin:0 auto; font-size: 14px;color:#323232;">Journey Details:<p>Journey Name : {{$journey->journey_name}}</p><p>Journey Assigned By : {{$journey->assigned_name}}</p><p>Optional or Compulsory : {{ucfirst($journey->read)}}</p><p>Milestone Count : {{$journey->milestone_count}}</p></span>
                                    </td>
                                </tr>
								<tr>
                                   <td style="padding-bottom:10px;">
                                         <span style="text-align:left; display:block; margin:0 auto; font-size: 14px;color:#323232;">Thanks,</span>
                                         <span style="text-align:left; display:block; margin:0 auto; font-size: 14px;color:#323232;">Learning Experience Platform</span>
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