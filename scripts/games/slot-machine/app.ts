/// <reference path="../../utils.ts"/>

ready(function(){

  class Slot {
    static icons:string[] = ['💀','💩','🙈','🍆','🍔','🍎','😀','❤','💰'];

    offset:number;
    isSpinning:boolean;
    $slot:$;
    $rows:$;
    callback:Function;
    private _destination:number;
    private _numSpins:number;

    constructor($slot:$){
      this.$slot = $slot;
      this.$rows = $slot.find('.row');
      this.offset = Math.floor(Math.random() * Slot.icons.length);
      this.isSpinning = false;
      this._destination = this.offset;
      this._numSpins = 0;
      this.callback = ()=>null;
      this.update();
    }

    set destination(value:number){
      this._destination = value % Slot.icons.length;
      this._numSpins = Math.round(Math.random() * 5 + 5);
    }

    spin(callback?:Function){
      this.callback = callback || (()=>null);
      this.isSpinning = true;
      this.update();
    }

    update(){
      if(this.isSpinning){
        this.offset = (this.offset+1)%Slot.icons.length;
        this.isSpinning = !(this.offset == this._destination && --this._numSpins <= 0);
        requestAnimationFrame(()=>this.update());
      } else {
        this.callback();
      }
      this.$rows.each((row,index)=>$(row).text(Slot.icons[(this.offset+index)%Slot.icons.length]));
    }

  }

  const slots:Slot[] = [];
  const $game:$ = $('.slot-machine-game');
  const $input:$ = $game.find('input.bet');
  const $button:$ = $game.find('.spin-btn');
  const $creditCount:$ = $('.credit-count');
  var spinning:boolean = false;

  function creditCount(value?:number){
    const credits:number = parseInt($creditCount.text()) || 0;
    if(value == undefined) return credits;
    else $creditCount.text(credits + value);
  }

  function isSpinning(){
    if(spinning) return true;
    for(let slot of slots) if(slot.isSpinning) return true;
    return false;
  }

  function spin(state:number, amount:number){
    let finished:number = 0;
    const winState:boolean = state > 2;
    const offset:number = winState ? state + 2 : Math.floor(Math.random() * Slot.icons.length);
    for(let i = 0; i < slots.length; i++){
      let slot:Slot = slots[i];
      slot.destination = offset + (winState ? 0 : i * (7 - state));
      slot.spin(()=>{
        if(++finished == 4){
          creditCount(amount);
          spinning = false;
        }
      });
    }
  }

  $button.on('click', ()=>{
    if(isSpinning()) return;
    spinning = true;
    let bet:number = parseInt($input.text()) || 1;
    if(bet < 1) bet = 1;
    creditCount(-bet);
    ajax({
      url: '/php/games/slot-machine/spin.php',
      params: {bet: bet},
      success: (d) => d.success && spin(parseInt(d.msg), parseInt(d.credits))
    })
  });

  $('.slot').each((slot)=>slots.push(new Slot($(slot))));

});
