<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Regulamento do Bolão
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto md:px-6 lg:px-8">
            <div class="bg-white shadow rounded-xl p-6 sm:p-10 space-y-6 text-gray-700 leading-relaxed">

                <section>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">1. Participação</h3>

                    <p><b>1.1.</b> A participação no bolão é válida para todas as pessoas que queiram participar, desde que autorizadas pelos organizadores.</p>
                    <p><b>1.2.</b> Cada participante poderá concorrer com apenas 1 aposta.</p>
                    <p><b>1.3.</b> As inscrições e apostas não se encerrarão. Quem entrar no meio da competição participará apenas dos jogos restantes.</p>
                    <p><b>1.4.</b> As apostas ficam visíveis imediatamente, mas só participam as autorizadas pelos organizadores.</p>
                    <p><b>1.5.</b> As apostas podem ser modificadas até 1 hora antes do início da partida. Durante as partidas, as apostas de todos poderão ser acompanhadas pelo painel do site.</p>
                    <p><b>1.6.</b> Para se cadastrar, o usuário deve informar: Nome completo, Indicação, E-mail e Telefone.</p>
                    <p><b>1.7.</b> O valor de cada aposta é de <b class="text-green-600">R$ {{ number_format(($valorBolao ?? 30), 2, ',', '.') }}</b>.</p>
                    <p><b>1.8.</b> O pagamento deverá ser feito via PIX com a seguinte chave: <b class="text-blue-600">(14) 99658-1771 - Cledemir Barduco Junior - NuBank</b>.</p>
                    <p><b>1.9.</b> Os pagamentos deverão ser realizados até o término da 1ª rodada da fase de grupos. Palpites não pagos serão EXCLUÍDOS!</p>
                </section>

                <section>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">2. Instruções para Aposta</h3>

                    <p><b>2.1.</b> Após se cadastrar, o participante terá acesso ao quadro de jogos e deverá preencher seus palpites.</p>
                    <p><b>2.2.</b> O usuário poderá selecionar resultados de todas as fases com data, hora, local, seleções e campos de escolha.</p>
                    <p><b>2.3.</b> O número de gols será escolhido a partir de valores pré-definidos.</p>
                    <p><b>2.4.</b> Após selecionar os resultados, deverá clicar em <b>Salvar Palpites</b>.</p>
                    <p><b>2.5.</b> Após salvar, poderá alterar até 1 hora antes do início do jogo.</p>
                    <p><b>2.6.</b> As fases seguintes só serão liberadas após a definição dos confrontos e tabela.</p>
                </section>

                <section>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">3. Pontuação</h3>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <ul class="list-disc pl-5">
                            <li>Placar exato: <b>6 pontos</b></li>
                            <li>Seleção vencedora: <b>3 pontos</b></li>
                            <li>Número de gols de uma seleção: <b>1 ponto</b></li>
                            <li>Total de gols da partida: <b>1 ponto</b></li>
                        </ul>
                    </div>
                    <div class="mt-6 overflow-x-auto">
                        <table class="w-full md:w-3/4  mx-auto border rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th colspan=2 class="px-4 py-2 text-left">Resultado do jogo de exemplo: Brasil 2 x 1 Marrocos</th>
                                </tr>
                                <tr>
                                    <th class="px-4 py-2 text-left">Palpite</th>
                                    <th class="px-4 py-2 text-left">Pontuação</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                <tr>
                                    <td class="px-4 py-2">Brasil 2 x 1 Marrocos</td>
                                    <td class="px-4 py-2">6 pontos — Placar Exato</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Brasil 2 x 0 Marrocos</td>
                                    <td class="px-4 py-2">4 pontos — Vencedor + gols</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Brasil 1 x 0 Marrocos</td>
                                    <td class="px-4 py-2">3 pontos — Vencedor</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Brasil 1 x 2 Marrocos</td>
                                    <td class="px-4 py-2">1 ponto — Total de gols</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Brasil 0 x 2 Marrocoss</td>
                                    <td class="px-4 py-2">0 pontos</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Pesos das Fases</h3>

                    <ul class="list-disc pl-5">
                        <li>Segunda fase (16-avos de final): <b>2x</b></li>
                        <li>Oitavas de Final: <b>3x</b></li>
                        <li>Quartas de Final: <b>4x</b></li>
                        <li>Semi Finais: <b>5x</b></li>
                        <li>Finais: <b>6x</b></li>
                    </ul>
                </section>

                <section>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Chute de Ouro</h3>

                    <p>Cada acerto no chute de ouro rende <b class="text-yellow-600">30 pontos extras</b>. Pode ser apostado até o início da fase de oitavas de final.</p>
                    <p>Os palpites do chute de ouro poderão ser registrados a partir do início da 2ª rodada da fase de grupos.</p>
                </section>

                <section>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">4. Casos Especiais</h3>

                    <p><b>4.1.</b> Jogos suspensos ou adiados não pontuam.</p>
                    <p><b>4.2.</b> Alterações posteriores em resultados não mudam a pontuação.</p>
                    <p><b>4.3.</b> A pontuação considera o tempo regulamentar (90 minutos + acréscimos) e a prorrogação a partir da segunda fase (16 avos de final).</p>
                    <p><b>4.4.</b> Bolão sem fins lucrativos.</p>
                </section>

                <section>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Premiação</h3>

                    <p><b>1º Lugar:</b> 60% do total arrecadado</p>
                    <p><b>2º Lugar:</b> 30% do total arrecadado</p>
                    <p><b>3º Lugar:</b> 10% do total arrecadado</p>

                    <div class="mt-4 p-4 bg-gray-50 border rounded-lg text-center">
                        <p>Total de participantes pagos: <b>{{ $participantes ?? '-' }}</b></p>
                        <p>Valor total arrecadado: <b>R$ {{ number_format(($participantes ?? 0) * ($valorBolao ?? 30), 2, ',', '.') }}</b></p>
                    </div>
                </section>

                <section class="text-sm text-gray-600">
                    <p>Dúvidas: <b>barduco@gmail.com</b></p>
                </section>

            </div>
        </div>
    </div>
</x-app-layout>