export class NotesError extends Error {
  constructor(message) {
    super(message);
    this.name = 'NotesError';
  }
}
