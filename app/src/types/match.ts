export interface Match {
  header: string;
  comment: string;
  date: Date;
}

export enum MatchJoinType {
  TEAM = 'team',
  OPEN = 'ffa',
}

export enum MatchVisibility {
  PUBLIC,
  PRIVATE,
}

export interface MatchCreatePayload {
  type: string;
  isRated: boolean;
  isPublic: boolean;
  bet: number;
  playersAmount: number;
  lat: number;
  long: number;
}
