import { SquadResponse } from './squadResponse';
import { UserProfilePayload } from './userProfilePayload';

export interface UserJoinedSquadEvent {
  squad: SquadResponse;
  user: UserProfilePayload;
}

export interface UserChangedSquadsEvent {
  squads: SquadResponse[];
}
