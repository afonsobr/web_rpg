document.addEventListener('DOMContentLoaded', function () {
    console.log('loaded battle.js');
    const $ = id => document.getElementById(id);

    // 🔄 Habilita ou desabilita comandos
    function toggleCommands(state) {
        ['battle-command-1', 'battle-command-2', 'battle-command-3']
            .forEach(id => $(id).classList.toggle('disabled', state === 'lock'));
    }

    function checkAndEnableCommands() {
        const partnerDs = parseInt(document.getElementById('partner-ds-info')?.textContent || 0);

        // Custo das skills (pode mudar depois se quiser)
        const skillCost = {
            1: 0,
            2: 11,
            3: 16
        };

        // Verifica cada botão individualmente
        for (let i = 1; i <= 3; i++) {
            const el = document.getElementById(`battle-command-${i}`);
            if (!el) continue;

            // Se o DS for suficiente, habilita; senão, bloqueia
            if (partnerDs >= skillCost[i]) {
                el.classList.remove('disabled');
            } else {
                el.classList.add('disabled');
            }
        }
    }

    window.enableCommands = () => checkAndEnableCommands();
    window.lockCommands = () => toggleCommands('lock');

    // Versão async, confiável para parceiros e inimigos
    window.digimonAttackAsync = function (attackerSide = 'partner', damageValue = 200, critical = false, trait = false) {
        return new Promise((resolve) => {
            const attacker = document.getElementById(`${attackerSide}-img`);
            const targetSide = attackerSide === 'partner' ? 'enemy' : 'partner';
            const target = document.getElementById(`${targetSide}-img`);
            const damageText = document.getElementById(`damage-text-${targetSide}`);

            if (!trait) {
                if (!critical) {
                    damageText.classList.remove('critical-damage');
                } else {
                    damageText.classList.add('critical-damage');
                }
            }
            else {
                damageText.classList.add('trait-damage');
            }

            if (!attacker || !target || !damageText) {
                console.error('Erro: elementos de batalha não encontrados.');
                resolve();
                return;
            }

            // Aplica ataque
            attacker.classList.add(`${attackerSide}-attack`);

            setTimeout(() => {
                target.classList.add('hit');
                if (critical) {
                    damageText.textContent = `-${damageValue} (CRIT)`;
                }
                else {
                    damageText.textContent = `-${damageValue}`;
                }

                damageText.classList.add('damage-rise');

                // Remove efeitos do alvo
                setTimeout(() => {
                    target.classList.remove('hit');
                    damageText.classList.remove('damage-rise');
                }, 800);
            }, 300);

            // Timeout de fallback caso não exista animação CSS
            const fallbackTimeout = setTimeout(() => {
                attacker.classList.remove(`${attackerSide}-attack`);
                resolve();
            }, 1200);

            // Se houver animação CSS, resolve quando acabar
            const onAnimationEnd = () => {
                clearTimeout(fallbackTimeout);
                attacker.classList.remove(`${attackerSide}-attack`);
                resolve();
            };

            // Adiciona listener apenas se existir animação
            const computedStyle = window.getComputedStyle(attacker);
            const animationName = computedStyle.getPropertyValue('animation-name');
            if (animationName && animationName !== 'none') {
                attacker.addEventListener('animationend', onAnimationEnd, { once: true });
            } else {
                // Se não houver animação, resolve no fallback
                setTimeout(onAnimationEnd, 0);
            }
        });
    };

    // Função de ataque do parceiro com async/await
    window.partnerAttack = async function (skillNumber) {
        lockCommands();

        battleSequence = await requestBattleTurns(skillNumber);
        console.log(battleSequence);

        await animateLog(battleSequence.data.log[0]);
        if (battleSequence.data.log[1]) {
            await new Promise(res => setTimeout(res, 300));
            await animateLog(battleSequence.data.log[1]);
        }
        if (!battleSequence.data.battleOver) {
            enableCommands();
        }
        else {
            // 🧩 Fim de Batalha
            (() => {
                const { winner, reward } = battleSequence.data;
                const partnerImg = document.getElementById('partner-img');
                const enemyImg = document.getElementById('enemy-img');

                // 🏆 Mensagem de resultado
                let resultMsg = '';

                if (winner === 'partner') {
                    resultMsg = `
                    <div class="text-lg pb-1"><b>Battle Results:</b></div>
                    You won!
                    ${reward ? `
                    <br><br>
                    +${reward.tamerExp} Tamer EXP<br>
                    +${reward.digimonExp} Digimon EXP<br>
                    +${reward.bits} BITs` : ''}`;
                } else {
                    resultMsg = `
                    <div class="text-lg pb-1"><b>Battle Results:</b></div>
                    You lost!`;
                }

                showAlertModal(resultMsg.trim(), () => { });

                // 🎛️ Atualiza botões da interface
                ['btn-battle-card', 'btn-abandon-battle'].forEach(id => {
                    document.getElementById(id).hidden = true;
                });
                document.getElementById('btn-close-battle').hidden = false;

                // 💫 Atualiza status visual dos Digimons
                [partnerImg, enemyImg].forEach(img => img.classList.remove('defeated-image'));

                const defeatedImg = winner === 'partner' ? enemyImg : partnerImg;
                defeatedImg.classList.add('defeated-image');
            })();
        }
        // Ataque do parceiro
        // await digimonAttackAsync('partner', rand(10, 50));
        // adjustHP((parseInt(document.getElementById('enemy-hp').style.width) - 3), 'enemy')

        // // Pequeno delay antes do inimigo atacar (para parecer natural)
        // await new Promise(res => setTimeout(res, 300));

        // // Ataque do inimigo
        // await digimonAttackAsync('enemy', rand(10, 50));
        // adjustHP((parseInt(document.getElementById('partner-hp').style.width) - 3), 'partner')
    };

    async function requestBattleTurns(partnerSkillNumber = 0) {
        const result = await apiRequest('api/api_battle', { action: 'battleTurns', partnerSkillNumber: partnerSkillNumber });
        return result;
    }

    async function animateLog(log) {
        if (log.attackerName == 0) {
            await digimonAttackAsync('partner', log.damage, log.critical, log.trait);
            await new Promise(res => setTimeout(res, 100));
            // Enemy
            adjustHP(log.defenderArray.hpPercent, 'enemy');

            // Partner
            adjustHP(log.attackerArray.hpPercent, 'partner');
            adjustHpAndDs(log.attackerArray.currentHp, log.attackerArray.currentDs);
        }
        else {
            await digimonAttackAsync('enemy', log.damage, log.critical, log.trait);
            await new Promise(res => setTimeout(res, 100));

            // Partner
            adjustHP(log.defenderArray.hpPercent, 'partner');
            adjustHpAndDs(log.defenderArray.currentHp, log.defenderArray.currentDs);

            // Enemy
            adjustHP(log.attackerArray.hpPercent, 'enemy');
        }
    }

    function adjustHP(newValue, target) {
        const hpBar = document.getElementById(target + '-hp');
        const hpText = document.getElementById(target + '-hp-text');

        // Obtém o valor atual exibido
        let currentValue = parseInt(hpText.textContent);

        // Atualiza a largura da barra de HP (anima via CSS transition)
        hpBar.style.width = newValue + '%';

        // Animação numérica
        const diff = newValue - currentValue;
        const stepTime = 20; // milissegundos por passo
        const totalSteps = Math.abs(diff);
        if (totalSteps === 0) return;

        let step = 0;
        const timer = setInterval(() => {
            step++;
            const progress = step / totalSteps;
            const nextValue = currentValue + Math.round(diff * progress);
            hpText.textContent = nextValue;

            if (step >= totalSteps) {
                hpText.textContent = newValue; // garante valor final exato
                clearInterval(timer);
            }
        }, stepTime);
    }

    function adjustHpAndDs(hpVal, dsVal) {
        const hpText = document.getElementById('partner-hp-info');
        const dsText = document.getElementById('partner-ds-info');
        hpText.innerHTML = hpVal;
        dsText.innerHTML = dsVal;
    }

    function rand(min, max) {
        min = Math.ceil(min); // Ensure min is an integer
        max = Math.floor(max); // Ensure max is an integer
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
})