<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apostas da Partida: {{ $partida->homeTeam }} x {{ $partida->awayTeam }}</title>
</head>

<body style="margin:0; padding:0; background:#f3f4f6;">

    <div style="font-family: Arial, Helvetica, sans-serif; background:#f3f4f6; padding:20px;">

        <div style="max-width:600px;margin:auto;background:#ffffff;padding:25px;border-radius:8px;">

            <!-- HEADER DA PARTIDA -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:15px;">
                <tr>
                    <td align="center">

                        <table cellpadding="0" cellspacing="0">
                            <tr>

                                <!-- Bandeira casa -->
                                <td style="padding-right:10px;">
                                    <img src="{{ $partida->homeTeamBandeira }}"
                                        width="36"
                                        style="display:block;"
                                        onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/b/b0/No_flag.svg';">
                                </td>

                                <!-- Nome time -->
                                <td style="font-size:16px;font-weight:bold;padding-right:8px;">
                                    {{ $partida->homeTeam }}
                                </td>

                                <!-- X -->
                                <td style="font-size:16px;font-weight:bold;padding-right:8px;">
                                    x
                                </td>

                                <!-- Nome visitante -->
                                <td style="font-size:16px;font-weight:bold;padding-right:10px;">
                                    {{ $partida->awayTeam }}
                                </td>

                                <!-- Bandeira visitante -->
                                <td>
                                    <img src="{{ $partida->awayTeamBandeira }}"
                                        width="36"
                                        style="display:block;"
                                        onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/b/b0/No_flag.svg';">
                                </td>

                            </tr>
                        </table>

                        <div style="font-size:13px;color:#666;margin-top:6px;">
                            {{ $partida->date }} - {{ $partida->hour }}
                        </div>

                    </td>
                </tr>
            </table>


            <!-- LISTA DE APOSTAS -->
            <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse:collapse;">

                <tbody>

                    @foreach($partida->palpites as $palpite)

                    <tr style="border-bottom:1px solid #eeeeee;">

                        <!-- Avatar + nome -->
                        <td style="width:70%;">

                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding-right:10px;vertical-align:middle;">
                                        <img src="{{ $palpite->user->avatar ?? config('app.url') .'/img/no-avatar.png' }}"
                                            width="36"
                                            height="36"
                                            style="border-radius:50%;display:block;"
                                            onerror="this.onerror=null;this.src='{{ config('app.url') }}/img/no-avatar.png';">
                                    </td>
                                    <td style="vertical-align:middle;font-size:14px;color:#333;">
                                        {{ $palpite->user->name }}
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <!-- Palpite -->
                        <td style="text-align:center;font-weight:500;font-size:14px;color:#444;">

                            @if($palpite->home_team_goals === null || $palpite->away_team_goals === null)
                            Não palpitou
                            @else
                            {{ $palpite->home_team_goals }} x {{ $palpite->away_team_goals }}
                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>