import { DateFormatter } from '@internationalized/date';

export function useDateFormatter() {
  const df = new DateFormatter(navigator.language, {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  });

  return { df };
}