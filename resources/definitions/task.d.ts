type Task = {
    id: number;
    created_at: string /* Date */ | null;
    updated_at: string /* Date */ | null;
    description: string | null;
    is_done: boolean;
    position: number;
};
