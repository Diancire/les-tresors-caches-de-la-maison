import axios from 'axios';

document.addEventListener('DOMContentLoaded', () => {
    const likeElements = [].slice.call(document.querySelectorAll('a[data-action="like"]'));
    if (likeElements) {
      new Like(likeElements);
    }
  })


export default class Like {
  constructor(likeElements) {
    this.likeElements = likeElements;

    if (this.likeElements) {
      this.init();
    }
}

init() {
    this.likeElements.map(element => {
      element.addEventListener('click', this.onClick)
    })
}

onClick(event) {
    event.preventDefault();
    const url = this.href;

    axios.get(url).then(res => {
      console.log(res, this);
      const nb = res.data.nbLike;
      const span = this.querySelector('span');

      this.dataset.nb = nb;
      span.innerHTML = nb + ' J\'aime';

      const thumbsUpFilled = this.querySelector('i.filled');
      const thumbsUpUnfilled = this.querySelector('i.unfilled');

      thumbsUpFilled.classList.toggle('hidden');
      thumbsUpUnfilled.classList.toggle('hidden');
    })
  }
}
